<template>
    <div class="adm-card">
        <h3 class="adm-card__title">Site settings</h3>
        <transition name="adm-fade" mode="out-in">
            <div v-if="loading" key="loading">
                <div v-for="n in 4" :key="n" class="adm-skel adm-skel-line" style="width: 60%; margin: 12px 0;"></div>
            </div>
            <div v-else-if="error" key="error" class="adm-empty adm-text-muted">{{ error }}</div>
            <div v-else key="content">
                <div v-if="Object.keys(settings).length === 0" class="adm-empty">
                    No site settings configured yet.
                </div>
                <table v-else class="adm-table">
                    <thead>
                        <tr>
                            <th style="width: 240px;">Key</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(val, key) in settings" :key="key">
                            <td><code>{{ key }}</code></td>
                            <td style="white-space: pre-wrap; word-break: break-word;">{{ val }}</td>
                        </tr>
                    </tbody>
                </table>
                <p class="adm-text-soft" style="margin-top: 14px; font-size: 0.85rem;">
                    Read-only view for now. Inline editing is coming in the next pass.
                </p>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';

const settings = ref({});
const loading = ref(true);
const error = ref('');

onMounted(async () => {
    try {
        const { data } = await api.get('/settings');
        settings.value = data.data ?? {};
    } catch (e) {
        error.value = 'Could not load settings.';
    } finally {
        loading.value = false;
    }
});
</script>
