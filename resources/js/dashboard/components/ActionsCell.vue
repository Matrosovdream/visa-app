<template>
    <div class="adm-actions">
        <router-link v-if="editTo" :to="editTo" class="adm-actions__btn" title="Edit">
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M11 2l3 3-8 8H3v-3l8-8z" />
            </svg>
        </router-link>
        <button v-if="onDelete" type="button" class="adm-actions__btn adm-actions__btn--danger"
            title="Delete" @click="onDelete">
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M3 4h10M6 4V2h4v2M5 4l1 10h4l1-10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
</template>

<script setup>
defineProps({
    editTo: { type: [Object, String], default: null },
    onDelete: { type: Function, default: null },
});
</script>
