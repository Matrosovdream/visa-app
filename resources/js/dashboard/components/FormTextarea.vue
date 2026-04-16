<template>
    <div class="adm-field">
        <label v-if="label" :for="id" class="adm-field__label">
            {{ label }}
            <span v-if="required" class="adm-field__required">*</span>
        </label>
        <textarea :id="id" v-bind="$attrs" :rows="rows" :value="modelValue"
            :placeholder="placeholder" :required="required" :disabled="disabled"
            :class="['adm-input', 'adm-textarea', { 'adm-input--error': error }]"
            @input="$emit('update:modelValue', $event.target.value)"></textarea>
        <div v-if="hint && !error" class="adm-field__hint">{{ hint }}</div>
        <div v-if="error" class="adm-field__error">{{ error }}</div>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: { type: String, default: '' },
    label: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    rows: { type: Number, default: 5 },
    id: { type: String, default: () => `ta-${Math.random().toString(36).slice(2, 9)}` },
});

defineEmits(['update:modelValue']);
defineOptions({ inheritAttrs: false });
</script>
