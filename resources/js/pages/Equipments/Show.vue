<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { router } from '@inertiajs/vue3';

defineOptions({ layout: MainLayout });

const props = defineProps({
    equipment: Object,
    image_url: String
});

const getStatusColor = (status) => {
    if (status === 'Em Uso') return 'positive';
    if (status === 'Disponível') return 'blue-7';
    if (status === 'Manutenção') return 'negative';
    return 'grey';
};
</script>

<template>
    <q-page class="q-pa-md">
        
        <div class="row items-center justify-between q-mb-md">
            <div>
                <div class="text-overline text-grey-7">Detalhes do Patrimônio</div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">
                    {{ equipment.asset_code }}
                </h1>
            </div>
            <div class="q-gutter-x-sm">
                <q-btn flat color="grey-8" icon="arrow_back" label="Voltar" @click="$inertia.visit('/equipamentos')" />
                <q-btn color="primary" icon="edit" label="Editar" @click="$inertia.visit(`/equipamentos/${equipment.id}/editar`)" />
            </div>
        </div>

        <q-card class="no-shadow" bordered>
            <div class="row">
                
                <div class="col-12 col-md-8 q-pa-lg">
                    
                    <div class="text-h6 q-mb-md text-primary">{{ equipment.name }}</div>

                    <div class="row q-col-gutter-md">
                        
                        <div class="col-12">
                            <q-chip :color="getStatusColor(equipment.status)" text-color="white" icon="info">
                                {{ equipment.status }}
                            </q-chip>
                            <q-chip v-if="equipment.is_rented" color="purple" text-color="white" icon="monetization_on">
                                Equipamento Alugado
                            </q-chip>
                            <q-chip v-else color="grey-7" text-color="white" icon="verified">
                                Patrimônio Próprio
                            </q-chip>
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-list separator>
                                <q-item class="q-px-none">
                                    <q-item-section>
                                        <q-item-label caption>Localização</q-item-label>
                                        <q-item-label class="text-weight-bold">{{ equipment.location?.name || 'Não definido' }}</q-item-label>
                                        <q-item-label caption v-if="equipment.location">{{ equipment.location.scope }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item class="q-px-none">
                                    <q-item-section>
                                        <q-item-label caption>Departamento</q-item-label>
                                        <q-item-label>{{ equipment.department?.name || '-' }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-list separator>
                                <q-item class="q-px-none">
                                    <q-item-section>
                                        <q-item-label caption>Grupo / Categoria</q-item-label>
                                        <q-item-label>{{ equipment.group?.name || '-' }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item class="q-px-none">
                                    <q-item-section>
                                        <q-item-label caption>Subgrupo</q-item-label>
                                        <q-item-label>{{ equipment.subgroup?.name || '-' }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </div>

                        <div class="col-12 q-mt-md">
                            <div class="text-subtitle2 text-grey-7">Descrição / Detalhes</div>
                            <div class="bg-grey-2 q-pa-md rounded-borders" style="min-height: 80px;">
                                {{ equipment.description || 'Nenhuma descrição informada.' }}
                            </div>
                        </div>

                        <div class="col-12 text-caption text-grey-5 q-mt-sm">
                            Cadastrado em: {{ new Date(equipment.created_at).toLocaleDateString('pt-BR') }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 bg-grey-1 flex flex-center border-left-md" style="min-height: 300px;">
                    
                    <div v-if="image_url" style="width: 100%; text-align: center; padding: 20px;">
                        <q-img 
                            :src="image_url" 
                            style="max-height: 400px; max-width: 100%; border-radius: 8px; border: 1px solid #ddd; background-color: white;"
                            fit="contain"
                        />
                        <div class="text-caption q-mt-sm text-grey-6">Foto do Ativo</div>
                    </div>

                    <div v-else class="text-center text-grey-5">
                        <q-icon name="image_not_supported" size="100px" />
                        <div class="text-h6">Sem Imagem</div>
                        <div class="text-caption">Nenhuma foto anexada</div>
                    </div>

                </div>

            </div>
        </q-card>

    </q-page>
</template>

<style scoped>
@media (min-width: 1024px) {
    .border-left-md {
        border-left: 1px solid rgba(0, 0, 0, 0.12);
    }
}
</style>