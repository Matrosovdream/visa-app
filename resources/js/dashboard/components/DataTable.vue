<template>
    <div class="adm-table-wrap">
        <div v-if="searchable" class="adm-table-toolbar">
            <div class="adm-table-toolbar__search">
                <input v-model="search" type="text" :placeholder="searchPlaceholder">
            </div>
            <slot name="toolbar-right" />
        </div>

        <transition name="adm-fade" mode="out-in">
            <div v-if="loading" key="loading">
                <div class="adm-loading">
                    <div v-for="n in 4" :key="n" class="adm-skel adm-skel-line" style="margin: 14px 16px;"></div>
                </div>
            </div>
            <div v-else-if="error" key="error" class="adm-empty adm-text-muted">{{ error }}</div>
            <div v-else-if="!filteredRows.length" key="empty" class="adm-empty">
                {{ emptyText }}
            </div>
            <table v-else key="table" class="adm-table">
                <thead>
                    <tr>
                        <th v-for="col in columns" :key="col.key" :style="col.width ? { width: col.width } : null">
                            {{ col.label }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in filteredRows" :key="row[rowKey]">
                        <td v-for="col in columns" :key="col.key">
                            <slot :name="`cell:${col.key}`" :row="row" :value="getCell(row, col.key)">
                                {{ getCell(row, col.key) }}
                            </slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </transition>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    rows: { type: Array, default: () => [] },
    columns: { type: Array, required: true },
    rowKey: { type: String, default: 'id' },
    loading: { type: Boolean, default: false },
    error: { type: String, default: '' },
    searchable: { type: Boolean, default: true },
    searchPlaceholder: { type: String, default: 'Search…' },
    emptyText: { type: String, default: 'No records found.' },
    searchKeys: { type: Array, default: () => [] },
});

const search = ref('');

function getCell(row, key) {
    return key.split('.').reduce((o, k) => (o == null ? o : o[k]), row);
}

const filteredRows = computed(() => {
    const q = search.value.trim().toLowerCase();
    if (!q) return props.rows;
    const keys = props.searchKeys.length
        ? props.searchKeys
        : props.columns.map((c) => c.key);
    return props.rows.filter((row) =>
        keys.some((k) => {
            const v = getCell(row, k);
            return v != null && String(v).toLowerCase().includes(q);
        })
    );
});
</script>
