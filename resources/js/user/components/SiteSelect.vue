<template>
    <div class="ss" :class="{ 'ss--open': isOpen, 'ss--disabled': disabled, 'ss--invalid': invalid }"
        ref="rootEl" @keydown.down.prevent="onArrowDown" @keydown.up.prevent="onArrowUp"
        @keydown.enter.prevent="onEnter" @keydown.esc.prevent="close" @keydown.tab="close">

        <button type="button" class="ss__control" :disabled="disabled"
            @click="toggle" :aria-expanded="isOpen" aria-haspopup="listbox">
            <span class="ss__value" :class="{ 'ss__value--placeholder': !hasValue }">
                {{ displayLabel }}
            </span>
            <span class="ss__chevron" aria-hidden="true">
                <svg viewBox="0 0 12 8" width="12" height="8">
                    <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor"
                        stroke-width="1.6" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>
        </button>

        <transition name="ss-pop">
            <div v-if="isOpen" class="ss__panel" role="listbox">
                <div v-if="searchable" class="ss__search">
                    <input ref="searchEl" v-model="query" type="text"
                        class="ss__search-input" :placeholder="searchPlaceholder"
                        @keydown.down.prevent="onArrowDown"
                        @keydown.up.prevent="onArrowUp"
                        @keydown.enter.prevent="onEnter"
                        @keydown.esc.prevent="close">
                </div>
                <ul class="ss__options" ref="listEl">
                    <li v-if="!filteredOptions.length" class="ss__empty">
                        {{ emptyText }}
                    </li>
                    <li v-for="(opt, i) in filteredOptions" :key="getValue(opt)"
                        class="ss__option"
                        :class="{
                            'ss__option--selected': isSelected(opt),
                            'ss__option--highlight': i === highlighted,
                        }"
                        role="option"
                        :aria-selected="isSelected(opt)"
                        @mouseenter="highlighted = i"
                        @click="select(opt)">
                        <slot name="option" :option="opt" :label="getLabel(opt)" :selected="isSelected(opt)">
                            <span class="ss__option-label">{{ getLabel(opt) }}</span>
                            <span v-if="isSelected(opt)" class="ss__check" aria-hidden="true">
                                <svg viewBox="0 0 14 14" width="14" height="14">
                                    <path d="M2.5 7.5L5.5 10.5L11.5 4"
                                        stroke="currentColor" stroke-width="1.8"
                                        fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </slot>
                    </li>
                </ul>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const props = defineProps({
    modelValue: { type: [String, Number, null], default: null },
    options: { type: Array, default: () => [] },
    valueKey: { type: String, default: 'value' },
    labelKey: { type: String, default: 'label' },
    // Custom label formatter: (option) => string. Overrides labelKey.
    formatLabel: { type: Function, default: null },
    placeholder: { type: String, default: 'Select…' },
    searchPlaceholder: { type: String, default: 'Search…' },
    searchable: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    invalid: { type: Boolean, default: false },
    emptyText: { type: String, default: 'No matches' },
});

const emit = defineEmits(['update:modelValue', 'change']);

const rootEl = ref(null);
const searchEl = ref(null);
const listEl = ref(null);
const isOpen = ref(false);
const query = ref('');
const highlighted = ref(-1);

function getValue(opt) {
    if (opt == null) return null;
    if (typeof opt !== 'object') return opt;
    return opt[props.valueKey] ?? opt.value ?? opt.id;
}

function getLabel(opt) {
    if (opt == null) return '';
    if (typeof opt !== 'object') return String(opt);
    if (props.formatLabel) return props.formatLabel(opt);
    return opt[props.labelKey] ?? opt.label ?? opt.name ?? String(getValue(opt));
}

function isSelected(opt) {
    return getValue(opt) === props.modelValue;
}

const selectedOption = computed(() =>
    props.options.find((o) => getValue(o) === props.modelValue) ?? null
);

const hasValue = computed(() => selectedOption.value != null);

const displayLabel = computed(() =>
    hasValue.value ? getLabel(selectedOption.value) : props.placeholder
);

const filteredOptions = computed(() => {
    if (!props.searchable) return props.options;
    const q = query.value.trim().toLowerCase();
    if (!q) return props.options;
    return props.options.filter((o) => getLabel(o).toLowerCase().includes(q));
});

function toggle() {
    if (props.disabled) return;
    isOpen.value ? close() : open();
}

function open() {
    isOpen.value = true;
    query.value = '';
    highlighted.value = Math.max(
        0,
        filteredOptions.value.findIndex((o) => isSelected(o))
    );
    nextTick(() => {
        if (props.searchable) searchEl.value?.focus();
        scrollToHighlight();
    });
}

function close() {
    isOpen.value = false;
}

function select(opt) {
    const v = getValue(opt);
    emit('update:modelValue', v);
    emit('change', v, opt);
    close();
}

function onArrowDown() {
    if (!isOpen.value) return open();
    const max = filteredOptions.value.length - 1;
    highlighted.value = highlighted.value < max ? highlighted.value + 1 : 0;
    scrollToHighlight();
}

function onArrowUp() {
    if (!isOpen.value) return open();
    const max = filteredOptions.value.length - 1;
    highlighted.value = highlighted.value > 0 ? highlighted.value - 1 : max;
    scrollToHighlight();
}

function onEnter() {
    if (!isOpen.value) return open();
    const opt = filteredOptions.value[highlighted.value];
    if (opt) select(opt);
}

function scrollToHighlight() {
    nextTick(() => {
        const list = listEl.value;
        if (!list) return;
        const el = list.children[highlighted.value];
        if (el && typeof el.scrollIntoView === 'function') {
            el.scrollIntoView({ block: 'nearest' });
        }
    });
}

function onClickOutside(event) {
    if (rootEl.value && !rootEl.value.contains(event.target)) close();
}

onMounted(() => document.addEventListener('mousedown', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('mousedown', onClickOutside));

// Reset query + highlight when options change.
watch(() => props.options, () => {
    highlighted.value = Math.max(
        0,
        filteredOptions.value.findIndex((o) => isSelected(o))
    );
});
watch(query, () => {
    highlighted.value = 0;
});
</script>

<style>
/* Theme-matched modern select.
   Colors track the site's green accent (#12b886 / #20c997).
   Not scoped so parent styles (e.g. form-grid) can affect width. */
.ss {
    position: relative;
    width: 100%;
    font-family: inherit;
    color: #212529;
}

.ss__control {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px 16px;
    background: #ffffff;
    border: 1px solid #dde1e6;
    border-radius: 10px;
    font-size: 0.95rem;
    line-height: 1.2;
    text-align: left;
    cursor: pointer;
    transition:
        border-color 160ms ease,
        box-shadow 160ms ease,
        background 160ms ease;
    min-height: 50px;
}
.ss__control:hover:not(:disabled) {
    border-color: #b8e4d3;
}
.ss__control:focus,
.ss__control:focus-visible {
    outline: none;
    border-color: #20c997;
    box-shadow: 0 0 0 3px rgba(32, 201, 151, 0.18);
}
.ss--open .ss__control {
    border-color: #20c997;
    box-shadow: 0 0 0 3px rgba(32, 201, 151, 0.18);
}
.ss--invalid .ss__control {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
}
.ss--disabled .ss__control {
    cursor: not-allowed;
    background: #f6f8fa;
    color: #8b95a1;
}

.ss__value {
    flex: 1 1 auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.ss__value--placeholder {
    color: #97a2ae;
}

.ss__chevron {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #6b7886;
    transition: transform 200ms ease, color 160ms ease;
}
.ss--open .ss__chevron {
    transform: rotate(180deg);
    color: #12b886;
}

.ss__panel {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #e6e9ed;
    border-radius: 10px;
    box-shadow: 0 12px 32px rgba(16, 24, 40, 0.12);
    overflow: hidden;
    z-index: 50;
}

.ss__search {
    padding: 10px 10px 6px;
    border-bottom: 1px solid #eef1f4;
    background: #fbfcfd;
}
.ss__search-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e1e5ea;
    border-radius: 8px;
    font-size: 0.9rem;
    background: #ffffff;
    transition: border-color 160ms ease, box-shadow 160ms ease;
}
.ss__search-input:focus {
    outline: none;
    border-color: #20c997;
    box-shadow: 0 0 0 3px rgba(32, 201, 151, 0.15);
}

.ss__options {
    list-style: none;
    margin: 0;
    padding: 6px;
    max-height: 280px;
    overflow-y: auto;
    scroll-behavior: smooth;
}

/* Slim scrollbar that matches the theme */
.ss__options::-webkit-scrollbar {
    width: 8px;
}
.ss__options::-webkit-scrollbar-thumb {
    background: #dde1e6;
    border-radius: 8px;
}
.ss__options::-webkit-scrollbar-thumb:hover {
    background: #c0c7cf;
}

.ss__option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 0.93rem;
    cursor: pointer;
    color: #343a40;
    transition: background 140ms ease, color 140ms ease;
}
.ss__option--highlight {
    background: rgba(32, 201, 151, 0.09);
    color: #0a7a57;
}
.ss__option--selected {
    background: rgba(32, 201, 151, 0.14);
    color: #0a7a57;
    font-weight: 600;
}
.ss__option--selected.ss__option--highlight {
    background: rgba(32, 201, 151, 0.22);
}

.ss__option-label {
    flex: 1 1 auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.ss__check {
    flex: 0 0 auto;
    display: inline-flex;
    color: #12b886;
}

.ss__empty {
    padding: 14px 12px;
    text-align: center;
    color: #8b95a1;
    font-size: 0.9rem;
}

/* Dropdown open/close transition */
.ss-pop-enter-active,
.ss-pop-leave-active {
    transition:
        opacity 150ms ease,
        transform 180ms cubic-bezier(0.16, 1, 0.3, 1);
    transform-origin: top center;
}
.ss-pop-enter-from,
.ss-pop-leave-to {
    opacity: 0;
    transform: translateY(-6px) scale(0.98);
}
</style>
