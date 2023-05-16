<template>
    <div class="card">
        <div class="card-header pb-0">
            <h6>Información por Empleado</h6>
        </div>
        <div class="card-body px-3 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Empleado</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Correo</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Departamento</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edad</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Salario</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nivel de Estudio</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Antigüedad</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ausencias</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actualización</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>
                            <p class="text-xs mb-0">{{ user.name }}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">{{ user.email }}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">{{ user.department.name }}</p>
                        </td>
                        <td class="align-middle text-center">
                            <p class="text-xs mb-0">{{ user.age }}</p>
                        </td>
                        <td class="align-middle text-center" v-for="item in 4" :key="item">
                            <span class="text-xs">{{ user.kpis[item-1] ? user.kpis[item-1].value : '--' }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-xs">{{ user.date }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "kpis-table",
    props: ['users']
};
</script>
