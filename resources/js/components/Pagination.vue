<style lang="scss">
.pagination {
    justify-content: flex-end !important;
    .page-stats {
        align-items: center;
        margin-right: 750px;
    }

    a{
        color: #ffffff !important;
    }
}
</style>

<template>

    <nav class="pagination"  style="margin-bottom: 100px">
        <span class="page-stats">
            {{pagination.from}} - {{pagination.to}} of {{filtered.length}}
            <span v-if="filtered.length < pagination.total">(filtered from {{pagination.total}} total entries)</span>
        </span>
        <a v-if="pagination.prevPage" class="btn btn-sm btn-info  pagination-previous" style="margin-right: 30px" @click="$emit('prev')">
            Prev
        </a>
        <a class="btn btn-sm btn-info  pagination-previous"  style="margin-right: 30px" v-else :disabled="true">
           Prev
        </a>

        <a v-if="pagination.nextPage" class="btn btn-sm btn-info  pagination-next"  @click="$emit('next')">
            Next
        </a>
        <a class="btn btn-sm btn-info  pagination-next" v-else :disabled="true"  >
            Next
        </a>
    </nav>
</template>

<script>
    export default {
        props: ['pagination', 'client', 'filtered']
    }
</script>