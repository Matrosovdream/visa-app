<template>
    <teleport to="body">
        <transition name="adm-modal">
            <div v-if="confirm.open" class="adm-modal" @mousedown.self="cancel">
                <div class="adm-modal__panel">
                    <h3 class="adm-modal__title">{{ confirm.title }}</h3>
                    <p v-if="confirm.message" class="adm-modal__message">{{ confirm.message }}</p>
                    <div class="adm-modal__actions">
                        <button type="button" class="adm-btn" @click="cancel">
                            {{ confirm.cancelLabel }}
                        </button>
                        <button type="button"
                            :class="['adm-btn', confirm.danger ? 'adm-btn--danger' : 'adm-btn--primary']"
                            @click="accept">
                            {{ confirm.confirmLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script setup>
import { useConfirmStore } from '../stores/confirm';
const confirm = useConfirmStore();

function accept() { confirm.resolve(true); }
function cancel() { confirm.resolve(false); }
</script>
