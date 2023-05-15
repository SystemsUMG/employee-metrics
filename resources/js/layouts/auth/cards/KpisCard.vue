<template>
    <div class="mb-4 card">
        <div class="px-3 py-4 card-body">
            <div class="d-flex" :class="directionReverse ? reverseDirection : ''">
                <div>
                    <div class="text-center icon icon-shape"
                         :class="`${iconBackground} border-radius-2xl`">
                        <i class="text-lg opacity-10" :class="iconClass" aria-hidden="true"></i>
                    </div>
                </div>
                <div>
                    <div class="numbers">
                        <p class="mb-0 text-sm text-uppercase font-weight-bold">{{ title }}</p>
                        <h5 class="font-weight-bolder">{{ value }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "kpis-card",
    data() {
        return {
            reverseDirection: "flex-row-reverse justify-content-between",
        };
    },
    props: {
        directionReverse: Boolean,
        title: {
            type: String,
            required: true,
        },
        value: {
            required: true,
        },
        iconClass: {
            type: String,
            required: true,
        },
        iconBackground: {
            type: String,
            default: "bg-white",
        },
    },
};
</script>
