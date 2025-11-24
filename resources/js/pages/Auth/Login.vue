<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
        
    form.post('/login', {
        onFinish: () => form.reset('password'), // Limpa a senha se der erro
    });
};
</script>

<template>
    <div class="fullscreen flex flex-center bg-grey-2">

        <q-card class="login-card no-shadow column" bordered>
            
            <q-card-section class="header-section row justify-between items-center q-py-lg q-px-xl">
                
                <img 
                    src="/img/logo.png" 
                    alt="DW Plus Tecnologia"
                    style="height: 65px; max-width: 300px; object-fit: contain;"
                />

                <div class="nav-links text-grey-8 q-gutter-x-xl">
                    <span class="cursor-pointer">INÍCIO</span>
                    <span class="cursor-pointer">SERVIÇOS</span>
                    <span class="cursor-pointer">ABRIR TICKETS</span>
                </div>
            </q-card-section>

            <q-separator />

            <q-card-section class="col flex flex-center form-section">
                
                <div class="form-wrapper"> 
                    
                    <h1 class="text-h4 text-center text-weight-bold q-mb-xl" style="color: #120a45">Login</h1>

                    <q-form @submit.prevent="submit" class="q-gutter-y-lg">
                        
                        <div>
                            <div class="text-left text-grey-9 q-mb-sm text-subtitle1">E-mail</div>
                            <q-input
                                v-model="form.email"
                                outlined
                                class="custom-rounded-input"
                                bg-color="white"
                            /> 
                        </div>

                        <div>
                            <div class="text-left text-grey-9 q-mb-sm text-subtitle1">Senha</div>
                            <q-input
                                v-model="form.password"
                                type="password"
                                outlined
                                class="custom-rounded-input"
                                bg-color="white"
                            />
                        </div>

                        <div class="row justify-center q-mt-lg">
                            <q-btn
                                label="Confirmar"
                                type="submit"
                                text-color="white"
                                unelevated
                                padding="10px 50px" 
                                class="rounded-borders-button"
                                size="md"
                                style="font-weight: 400; background-color: #120a45; text-transform: none; font-size: 16px;" 
                            />
                        </div>
                    </q-form>
                </div>
            </q-card-section>
        </q-card>
    </div>
</template>

<style lang="scss" scoped>
/* CONFIGURAÇÃO DO CARTÃO GIGANTE */
.login-card {
    width: 94vw;        /* 94% da largura da tela */
    min-height: 90vh;   /* 90% da altura da tela */
    border-radius: 20px;
    border-color: #d0d0e5;
    background-color: #fafafa;
    max-width: 1800px; 
}

/* CONFIGURAÇÃO DO "MIOLO" DO FORMULÁRIO (LIMITADOR) */
.form-wrapper {
    width: 100%;
    max-width: 450px; /* Limita a largura dos inputs */
    margin: 0 auto;
}

/* Links do Menu Superior */
.nav-links span {
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: color 0.3s;
    &:hover { color: #120a45; }
}

/* Estilização Personalizada dos Inputs */
:deep(.custom-rounded-input) {
    .q-field__control {
        border-radius: 12px !important; /* Borda arredondada suave */
        height: 48px; /* Altura compacta */
    }
    .q-field__control:before {
        border-color: #a5a5c7; 
    }
    .q-field__control:after {
        border-color: #120a45;
        border-width: 2px;
    }
    .q-field__native {
        padding-left: 12px;
        min-height: 48px;
        padding-top: 0;
        padding-bottom: 0;
    }
}

/* Estilo do Botão */
.rounded-borders-button {
    border-radius: 8px;
}
</style>