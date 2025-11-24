<script setup>
// Importamos o Layout que acabamos de criar
import MainLayout from '@/Layouts/MainLayout.vue';

// Essa configuração diz ao Inertia: "Use o MainLayout como moldura para esta página"
defineOptions({
    layout: MainLayout
});
</script>

<template>
    <q-page class="q-pa-md">
        
        <div class="row q-col-gutter-md">
            <div class="col-12">
                <q-card bordered class="no-shadow">
                    <q-card-section>
                        <div class="text-h6 text-primary">Bem-vindo ao Sistema!</div>
                        <div class="text-subtitle2">Você está logado.</div>
                    </q-card-section>

                    <q-card-section>
                        Aqui você poderá ver gráficos e estatísticas das mitadas em breve.
                    </q-card-section>
                </q-card>
            </div>

            <div class="col-12 col-md-4">
                <q-card class="bg-primary text-white no-shadow">
                    <q-card-section align="center">
                        <q-icon name="groups" size="50px" />
                        <div class="text-h4 q-mt-sm">150</div>
                        <div class="text-subtitle1">Usuários Ativos</div>
                    </q-card-section>
                </q-card>
            </div>
        </div>

    </q-page>
</template>