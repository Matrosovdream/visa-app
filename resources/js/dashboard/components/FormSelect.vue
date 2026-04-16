<template>
    <div class="adm-field">
        <label v-if="label" :for="id" class="adm-field__label">
            {{ label }}
            <span v-if="required" class="adm-field__required">*</span>
        </label>
        <select :id="id" v-bind="$attrs" :value="modelValue"
            :required="required" :disabled="disabled"
            :class="['adm-input', { 'adm-input--error': error }]"
            @change="$emit('update:modelValue', castValue($event.target.value))">
            <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
            <option v-for="opt in options" :key="getKey(opt)" :value="getValue(opt)">
                {{ getLabel(opt) }}
            </option>
        </select>
        <div v-if="hint && !error" class="adm-field__hint">{{ hint }}</div>
        <div v-if="error" class="adm-field__error">{{ error }}</div>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: { type: [String, Number, Boolean, null], default: null },
    options: { type: Array, default: () => [] },
    valueKey: { type: String, default: 'value' },
    labelKey: { type: String, default: 'label' },
    label: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    numeric: { type: Boolean, default: false },
    id: { type: String, default: () => `s-${Math.random().toString(36).slice(2, 9)}` },
});

defineEmits(['update:modelValue']);
defineOptions({ inheritAttrs: false });

function getValue(opt) {
    if (opt == null || typeof opt !== 'object') return opt;
    return opt[props.valueKey] ?? opt.value ?? opt.id;
}
function getKey(opt) {
    return getValue(opt) ?? getLabel(opt);
}
function getLabel(opt) {
    if (opt == null || typeof opt !== 'object') return String(opt);
    return opt[props.labelKey] ?? opt.label ?? opt.name ?? opt.title ?? String(getValue(opt));
}
function castValue(v) {
    if (v === '') return null;
    if (props.numeric) {
        const n = Number(v);
        return Number.isNaN(n) ? v : n;
    }
    return v;
}
</script>
