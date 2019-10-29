<template>
<div>
    <div class="users">

        <div class="tableFilters">
            <div  style="margin-top: 40px">
                <h1 style="float: contour">All Users</h1>
              
             <router-link to="/">
                <button class="btn btn-info" style="float:left;margin-bottom: 10px">
             Add New User
             </button>
             </router-link>
             <br/>

            </div>
            
         

            <input class="form-control" type="text" v-model="search" placeholder="Search Table"
                   @input="resetPagination()">
            <div class="control" style="margin-left: 900px">
                <div class="select">
                    <select v-model="length" @change="resetPagination()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy" >
            <tbody>
            <tr v-for="(user,index) in paginated"  :key="index">
                <td>{{index + 1}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.mobile}}</td>
                <td>
                    <div class="ml-auto text-muted">
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteUser(user)"  >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </datatable>
        <pagination :pagination="pagination" :client="true" :filtered="filteredUsers"
                    @prev="--pagination.currentPage"
                    @next="++pagination.currentPage">
        </pagination>
    </div>

</div>
</template>

<script>
    import Datatable from './Datatable.vue';
    import Pagination from './Pagination.vue';
    export default {
        components: { datatable: Datatable, pagination: Pagination },
        created() {
            this.getUsers();
        },
        data() {
            let sortOrders = {};

            let columns = [
                {width: '5%', label: '#'},
                {width: '20%', label: 'Name', name: 'name', type: 'text' },
                {width: '33%', label: 'Email', name: 'email', type: 'text'},
                {width: '20%', label: 'Mobile', name: 'mobile',type:'number'},
                {width: '10%', label: 'Actions'}
            ];

            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                users: [],
                columns: columns,
                sortKey: 'name',
                sortOrders: sortOrders,
                length: 10,
                search: '',
                tableData: {
                    client: true,
                },
                pagination: {
                    currentPage: 1,
                    total: '',
                    nextPage: '',
                    prevPage: '',
                    from: '',
                    to: ''
                },
            }
        },
        methods: {
            getUsers(url = '/vueitems') {
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        this.users = response.data;
                        this.pagination.total = this.users.length;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            deleteUser: function deleteUser(user) {
                var _this = this;
                axios.post('/users/show/' + user.id).then(function (response) {
                    _this.getUsers();

                });
            },
            paginate(array, length, pageNumber) {
                this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
                this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
                this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
                this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
                return array.slice((pageNumber - 1) * length, pageNumber * length);
            },
            resetPagination() {
                this.pagination.currentPage = 1;
                this.pagination.prevPage = '';
                this.pagination.nextPage = '';
            },
            sortBy(key) {
                this.resetPagination();
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
        },
        computed: {
            filteredUsers() {
                let users = this.users;
                if (this.search) {
                    users = users.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    });
                }
                let sortKey = this.sortKey;
                let order = this.sortOrders[sortKey] || 1;
                if (sortKey) {
                    users = users.slice().sort((a, b) => {
                        let index = this.getIndex(this.columns, 'name', sortKey);
                        a = String(a[sortKey]).toLowerCase();
                        b = String(b[sortKey]).toLowerCase();
                         if (this.columns[index].type && this.columns[index].type === 'number') {
                            return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
                        } else {
                            return (a === b ? 0 : a > b ? 1 : -1) * order;
                        }
                    });
                }
                return users;
            },
            paginated() {
                return this.paginate(this.filteredUsers, this.length, this.pagination.currentPage);
            }
        }
    };
</script>
