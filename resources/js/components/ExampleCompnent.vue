<template>
    <div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center no-repeat ">
            <div class="auth-box">
                <div>
                    <div class="logo">
                        <h5 class="font-medium m-b-20">Add New User</h5>
                    </div>
                    <!-- Form -->
                    <p class="text-center alert alert-danger" v-bind:class="{ hidden: hasError }">Please fill all fields!</p>
                    <div class="row">
                        <div class="col-12">
                                <div class="form-group row ">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" type="text" required=" " v-model="newItem.name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" type="text" required=" "  v-model="newItem.email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" type="number" required=" "  v-model="newItem.mobile" placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="form-group text-center ">
                                    <div class="col-xs-12 p-b-20 ">
                                        <button class="btn btn-block btn-lg btn-info " @click.prevent="createItem()">Add</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {

        data(){
           return{
               items: [],
               hasError: true,
               newItem: { 'name': '','email': '','mobile': '' },
               router:'routes',
           }
        },

        methods: {
            createItem: function createItem() {
                var input = this.newItem;
                var _this = this;
                if (input['name'] === '' || input['email'] === '' || input['mobile'] === '') {
                    this.hasError = false;
                } else {
                    this.hasError = true;
                    axios.post('/vueitems', input).then(function (response) {
                        _this.newItem = {'name': '', 'email': '', 'mobile': ''};
                        _this.$router.push({ name: 'Users'} );

                    });

                }
            },

        },


    }

</script>



