<template>
    <div class="text-center" v-if="loader">
        <b-spinner variant="primary" label="Text Centered"></b-spinner>
    </div>
    <div v-else>
    <b-container fluid>
        <b-row>
        <b-col lg="5" class="my-1">
            <b-form-group
                label="Filter"
                label-for="filter-input"
                label-cols-sm="3"
                label-align-sm="right"
                label-size="sm"
                class="mb-0"
            >
                <b-input-group size="sm">
                    <b-form-input
                        id="filter-input"
                        v-model="filter"
                        type="search"
                        placeholder="Type to Search"
                    ></b-form-input>

                    <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>

        <!-- User Interface controls -->
            <b-col lg="6" class="my-1">
                <b-form-group
                    label="Sort"
                    label-for="sort-by-select"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    v-slot="{ ariaDescribedby }"
                >
                    <b-input-group size="sm" class="mt-2">
                        <b-form-select
                            id="sort-by-select"
                            v-model="sortBy"
                            :options="sortOptions"
                            :aria-describedby="ariaDescribedby"
                            class="w-75 p-1"
                        >
                            <template #first>
                                <option value="">-- none --</option>
                            </template>
                        </b-form-select>

                        <b-form-select
                            v-model="sortDesc"
                            :disabled="!sortBy"
                            :aria-describedby="ariaDescribedby"
                            size="sm"
                            class="w-25"
                        >
                            <option :value="false">Asc</option>
                            <option :value="true">Desc</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
        <b-col sm="5" md="6" class="my-1">
            <b-form-group
                label="Per page"
                label-for="per-page-select"
                label-cols-sm="6"
                label-cols-md="4"
                label-cols-lg="3"
                label-align-sm="right"
                label-size="sm"
                class="mb-0"
            >
                <b-form-select
                    id="per-page-select"
                    v-model="perPage"
                    :options="pageOptions"
                    size="sm"
                ></b-form-select>
            </b-form-group>
        </b-col>
        <!-- Main table element -->
        <b-table
            :tbody-tr-class="rowClass"
            :items="items"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            :filter-included-fields="filterOn"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection"
            stacked="md"
            show-empty
            small
            @filtered="onFiltered"
        >
            <template #cell(name)="row">
                {{ row.value.first }} {{ row.value.last }}
            </template>


            <template #row-details="row">
                <b-card>
                    <ul>
                        <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                </b-card>
            </template>
        </b-table>
        <b-col sm="7" md="4" class="my-1">
            <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                align="fill"
                size="sm"
                class="my-0"
            ></b-pagination>
        </b-col>
    </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loader: true,
            items: [],
            fields: [
                { key: 'Token', sortable: true, sortDirection: 'asc', class: 'text-center',variant:'info'},
                { key: 'Symbol',  sortable: true, class: 'text-center' },
                { key: 'Invest Amount',  sortable: true, class: 'text-center' },
                { key: 'Current Amount',  sortable: true, class: 'text-center' },
                { key: 'ROI',  sortable: true, class: 'text-center' },

            ],
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
            sortBy: 'Token',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: [],
            infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
            }
        }
    },
    computed: {
        sortOptions() {
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.key, value: f.key }
                })
        }
    },
    mounted() {
        this.allTokens()
    },
    methods: {
        rowClass(item, type) {
            if (!item || type !== 'row') return
            if (parseInt(item.ROI) < 0 ) return 'table-danger'
            else  return 'table-success'
        },
         allTokens() {
             axios.get('getAllTokens')
                .then((res =>{
                    this.items = res.data
                    this.totalRows = this.items.length
                    this.loader = false

                }))
                .catch((error => {
                    console.log(error.message)
                }))
        },

        onFiltered(filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        }
    }
}
</script>
<style >
.sr-only{
    display: none !important;
}
</style>
