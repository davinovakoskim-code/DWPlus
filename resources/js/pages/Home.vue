<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineOptions({ layout: MainLayout });


const props = defineProps({
    stats: Object 
});
</script>

<template>
    <Head title="Visão Geral" />
    <q-page class="q-pa-md bg-grey-1">
        
        <div class="q-mb-lg">
            <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Dashboard de Ativos</h1>
        </div>
        
        <div class="row q-col-gutter-md q-mb-lg">
            
            <div class="col-12 col-md-3">
                <q-card class="no-shadow border-left-warning full-height">
                    <q-card-section>
                        <div class="row items-center justify-between">
                            <div>
                                <div class="text-subtitle2 text-grey-7">Total de Ativos</div>
                                <div class="text-h3 text-weight-bold text-warning">{{ stats.total }}</div>
                            </div>
                            <q-icon name="dns" size="40px" class="text-orange-1" />
                        </div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3">
                <q-card class="no-shadow border-left-success full-height">
                    <q-card-section>
                        <div class="row items-center justify-between">
                            <div>
                                <div class="text-subtitle2 text-grey-7">Em Uso</div>
                                <div class="text-h3 text-weight-bold text-positive">{{ stats.em_uso }}</div>
                            </div>
                            <q-icon name="check_circle" size="40px" class="text-green-1" />
                        </div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3">
                <q-card class="no-shadow border-left-primary full-height">
                    <q-card-section>
                        <div class="row items-center justify-between">
                            <div>
                                <div class="text-subtitle2 text-grey-7">Disponíveis</div>
                                <div class="text-h3 text-weight-bold text-primary">{{ stats.disponivel }}</div>
                            </div>
                            <q-icon name="inventory_2" size="40px" class="text-blue-1" />
                        </div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-3">
                <q-card class="no-shadow border-left-danger full-height">
                    <q-card-section>
                        <div class="row items-center justify-between">
                            <div>
                                <div class="text-subtitle2 text-grey-7">Manutenção</div>
                                <div class="text-h3 text-weight-bold text-negative">{{ stats.manutencao }}</div>
                            </div>
                            <q-icon name="build" size="40px" class="text-red-1" />
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <div class="row q-col-gutter-md">
            
            <div class="col-12">
                <q-card class="no-shadow full-height" bordered>
                    <q-card-section>
                        <div class="text-h6 text-grey-8">Ações Rápidas</div>
                    </q-card-section>
                    <q-separator />
                    <q-list separator>
                        
                        <q-item clickable v-ripple @click="router.get('/equipamentos/criar')">
                            <q-item-section avatar>
                                <q-avatar color="blue-1" text-color="primary" icon="add" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Novo Equipamento</q-item-label>
                                <q-item-label caption>Cadastrar um novo ativo no sistema</q-item-label>
                            </q-item-section>
                        </q-item>
                        
                        <q-item clickable v-ripple @click="router.get('/equipamentos')">
                            <q-item-section avatar>
                                <q-avatar color="grey-3" text-color="grey-8" icon="list" />
                            </q-item-section>
                            <q-item-section>Ver Todos os Equipamentos</q-item-section>
                        </q-item>
                        
                    </q-list>
                </q-card>
            </div>
        </div>

    </q-page>
</template>

<style scoped>
.border-left-primary { border-left: 5px solid #1976D2; }
.border-left-success { border-left: 5px solid #21BA45; }
.border-left-warning { border-left: 5px solid #F2C037; }
.border-left-danger  { border-left: 5px solid #C10015; }
</style>