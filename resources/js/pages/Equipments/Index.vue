<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useQuasar } from 'quasar';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineOptions({ layout: MainLayout });

const $q = useQuasar();

const props = defineProps({
    equipments: Array
});


const filter = ref('');


const columns = [
  { name: 'asset_code', align: 'left', label: 'Patrimônio', field: 'asset_code', sortable: true },
  { name: 'name', align: 'left', label: 'Equipamento', field: 'name', sortable: true },
  {
    name: 'location',
    align: 'left',
    label: 'Localização',
    field: row => row.location ? row.location.name : '-',
    sortable: true
  },
  { name: 'is_rented', align: 'center', label: 'Tipo', field: 'is_rented', sortable: true },
  { name: 'status', align: 'center', label: 'Status', field: 'status', sortable: true },
  { name: 'actions', align: 'right', label: 'Ações' }
];


const getStatusColor = (status) => {
    if (status === 'Em Uso') return 'positive';
    if (status === 'Disponível') return 'blue-7';
    if (status === 'Manutenção') return 'negative';
    if (status === 'Baixado') return 'grey-8';
    return 'grey';
};

// Função para Deletar
const deleteItem = (id) => {
    $q.dialog({
        title: 'Atenção',
        message: 'Tem certeza que deseja excluir este patrimônio?',
        cancel: true,
        persistent: true,
        ok: { label: 'Excluir', color: 'negative', flat: true },
        cancel: { label: 'Cancelar', color: 'grey-8', flat: true }
    }).onOk(() => {
        router.delete(`/equipamentos/${id}`, {
            onSuccess: () => $q.notify({ type: 'positive', message: 'Excluído com sucesso!' })
        });
    });
};


const customFilter = (rows, terms, cols, getCellValue) => {
    const lowerTerms = terms ? terms.toLowerCase() : '';

    return rows.filter(row => {

        const textMatch = cols.some(col => {
            const val = getCellValue(col, row);
            return (val + '').toLowerCase().indexOf(lowerTerms) > -1;
        });


        let typeMatch = false;

        if (lowerTerms === 'alugado' && row.is_rented) typeMatch = true;

        if ((lowerTerms === 'próprio' || lowerTerms === 'proprio') && !row.is_rented) typeMatch = true;

        return textMatch || typeMatch;
    });
};
</script>

<template>
    <q-page class="q-pa-md">

        <div class="row items-center justify-between q-mb-md">

            <div class="col-12 col-md-4">
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Inventário</h1>
                <div class="text-grey-7">Gerencie o patrimônio da empresa</div>
            </div>

            <div class="col-12 col-md-8 row justify-end q-gutter-x-sm items-center">
                <q-input
                    outlined
                    dense
                    v-model="filter"
                    placeholder="Pesquisar ativo..."
                    class="bg-white"
                    style="min-width: 250px;"
                >
                    <template v-slot:prepend>
                        <q-icon name="search" />
                    </template>
                    <template v-slot:append v-if="filter">
                        <q-icon name="close" @click="filter = ''" class="cursor-pointer" />
                    </template>
                </q-input>

                <q-btn
                    color="primary"
                    icon="add"
                    label="Novo Ativo"
                    @click="router.get('/equipamentos/criar')"
                />
            </div>
        </div>

        <q-card class="no-shadow" bordered>
            <div class="scroll-container">
                <q-table
                    flat
                    :rows="equipments"
                    :columns="columns"
                    row-key="id"
                    :pagination="{ rowsPerPage: 25 }" :filter="filter"
                    :filter-method="customFilter"
                >

                    <template v-slot:body-cell-is_rented="props">
                        <q-td :props="props">
                            <q-badge v-if="props.row.is_rented" color="purple" label="Alugado" outline />
                            <q-badge v-else color="grey-7" label="Próprio" outline />
                        </q-td>
                    </template>

                    <template v-slot:body-cell-status="props">
                        <q-td :props="props">
                            <q-chip
                                :color="getStatusColor(props.row.status)"
                                text-color="white" dense size="sm" class="text-weight-bold"
                            >
                                {{ props.row.status }}
                            </q-chip>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-actions="props">
                        <q-td :props="props">
                            <q-btn flat round color="primary" icon="visibility" size="sm" @click="router.get(`/equipamentos/${props.row.id}`)">
                                <q-tooltip>Ver Detalhes</q-tooltip>
                            </q-btn>
                            <q-btn flat round color="grey-7" icon="edit" size="sm" @click="router.get(`/equipamentos/${props.row.id}/editar`)">
                                <q-tooltip>Editar</q-tooltip>
                            </q-btn>
                            <q-btn flat round color="negative" icon="delete" size="sm" @click="deleteItem(props.row.id)">
                                <q-tooltip>Excluir</q-tooltip>
                            </q-btn>
                        </q-td>
                    </template>

                    <template v-slot:no-data>
                        <div class="full-width row flex-center q-pa-md text-grey-7">
                            <q-icon name="search_off" size="sm" class="q-mr-sm" />
                            <span>Nenhum patrimônio encontrado com esse termo.</span>
                        </div>
                    </template>

                </q-table>
            </div>
        </q-card>

    </q-page>
</template>

<style scoped>
.scroll-container {
  
  height: calc(100vh - 200px);

  
  overflow-y: auto;
}
.scroll-container::-webkit-scrollbar {
  width: 8px;
}

.scroll-container::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.scroll-container::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

.scroll-container::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>