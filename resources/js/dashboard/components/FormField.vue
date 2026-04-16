<template>
    <div class="adm-field">
        <label v-if="label" :for="id" class="adm-field__label">
            {{ label }}
            <span v-if="required" class="adm-field__required">*</span>
        </label>
        <input :id="id" v-bind="$attrs" :type="type" :value="modelValue"
            :placeholder="placeholder" :required="required" :disabled="disabled"
            :class="['adm-input', { 'adm-input--error': error }]"
            @input="$emit('update:modelValue', $event.target.value)">
        <div v-if="hint && !error" class="adm-field__hint">{{ hint }}</div>
        <div v-if="error" class="adm-field__error">{{ error }}</div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: { type: [String, Number, null], default: '' },
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    id: { type: String, default: () => `f-${Math.random().toString(36).slice(2, 9)}` },
});

defineEmits(['update:modelValue']);
defineOptions({ inheritAttrs: false });
</script>
