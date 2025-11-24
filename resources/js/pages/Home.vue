<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });
</script>

<template>
    <q-page class="q-pa-md">
        
        <div class="row items-center justify-between q-mb-md">
            <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Dashboard de Ativos</h1>
            <div class="text-grey-7">Visão geral do parque tecnológico</div>
        </div>
        
        <div class="row q-col-gutter-md">
            
            <div class="col-12 col-sm-6 col-md-3">
                <q-card class="no-shadow border-left-primary" bordered>
                    <q-card-section class="row items-center justify-between">
                        <div>
                            <div class="text-subtitle2 text-grey-7">Total de Ativos</div>
                            <div class="text-h4 text-weight-bold text-primary">1.240</div>
                        </div>
                        <q-icon name="dns" size="40px" class="text-blue-1" />
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <q-card class="no-shadow border-left-success" bordered>
                    <q-card-section class="row items-center justify-between">
                        <div>
                            <div class="text-subtitle2 text-grey-7">Em Uso</div>
                            <div class="text-h4 text-weight-bold text-positive">980</div>
                        </div>
                        <q-icon name="check_circle" size="40px" class="text-green-1" />
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <q-card class="no-shadow border-left-warning" bordered>
                    <q-card-section class="row items-center justify-between">
                        <div>
                            <div class="text-subtitle2 text-grey-7">Disponíveis</div>
                            <div class="text-h4 text-weight-bold text-warning">245</div>
                        </div>
                        <q-icon name="inventory_2" size="40px" class="text-orange-1" />
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <q-card class="no-shadow border-left-danger" bordered>
                    <q-card-section class="row items-center justify-between">
                        <div>
                            <div class="text-subtitle2 text-grey-7">Manutenção</div>
                            <div class="text-h4 text-weight-bold text-negative">15</div>
                        </div>
                        <q-icon name="build" size="40px" class="text-red-1" />
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <div class="row q-mt-lg q-col-gutter-md">
            <div class="col-12 col-md-8">
                <q-card bordered class="no-shadow full-height">
                    <q-card-section>
                        <div class="text-h6 text-grey-9">Movimentações Recentes</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section class="flex flex-center text-grey-5" style="min-height: 200px">
                        <div class="text-center">
                            <q-icon name="history" size="50px" />
                            <p>Nenhuma movimentação registrada hoje.</p>
                        </div>
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-4">
                <q-card bordered class="no-shadow full-height">
                    <q-card-section>
                        <div class="text-h6 text-grey-9">Ações Rápidas</div>
                    </q-card-section>
                    <q-separator />
                    <q-list separator>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-avatar color="blue-1" text-color="primary" icon="add" />
                            </q-item-section>
                            <q-item-section>Novo Equipamento</q-item-section>
                        </q-item>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-avatar color="green-1" text-color="positive" icon="person_add" />
                            </q-item-section>
                            <q-item-section>Nova Alocação</q-item-section>
                        </q-item>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-avatar color="red-1" text-color="negative" icon="report_problem" />
                            </q-item-section>
                            <q-item-section>Reportar Defeito</q-item-section>
                        </q-item>
                    </q-list>
                </q-card>
            </div>
        </div>

    </q-page>
</template>

<style scoped>
/* Bordas coloridas para destacar os cards */
.border-left-primary { border-left: 5px solid #1976D2; }
.border-left-success { border-left: 5px solid #21BA45; }
.border-left-warning { border-left: 5px solid #F2C037; }
.border-left-danger  { border-left: 5px solid #C10015; }
</style>