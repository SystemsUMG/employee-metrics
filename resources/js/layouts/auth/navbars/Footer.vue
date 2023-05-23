<template>
    <footer class="py-3 footer">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="mb-4 col mb-lg-0">
                    <div class="text-sm text-center copyright text-muted">
                        © {{ new Date().getFullYear() }}, hecho por
                        <span class="font-weight-bold">
                            <a href="https://github.com/cris-gf" target="_blank">cris-gf</a>
                            &
                            <a href="https://github.com/BSRoberto" target="_blank">BSRoberto</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "app-footer",
};
</script>
