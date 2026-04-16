<template>
    <teleport to="body">
        <div class="adm-toasts">
            <transition-group name="adm-toast">
                <div v-for="t in toast.items" :key="t.id"
                    :class="['adm-toast', `adm-toast--${t.type}`]"
                    @click="toast.dismiss(t.id)">
                    <div class="adm-toast__dot"></div>
                    <div class="adm-toast__msg">{{ t.message }}</div>
                </div>
            </transition-group>
        </div>
    </teleport>
</template>

<script setup>
import { useToastStore } from '../stores/toast';
const toast = useToastStore();
</script>
