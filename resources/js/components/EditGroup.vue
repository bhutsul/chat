<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="name" id="name" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="groupStatus">Status group</label>
                                <select class="form-control" id="groupStatus" v-model="status">
                                    <option value="1">open</option>
                                    <option value="0">close</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button @click="updateGroup($event)" type="submit" class="btn btn-primary">Update</button>
                                <button @click="deleteGroup($event)" class="btn btn-outline-danger">Delete group</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <b-tabs content-class="mt-3">
                        <b-tab title="Users" active>
                            <div class="card-body">
                                <ul class="list-group" v-if="this.group.users.length != 0">
                                    <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(user, index) in this.group.users" :key="index" v-if="user.pivot.confirmed != 0">
                                        {{ user.name }}
                                        <button v-if="user.id != group.admin_id" @click="kickUser(user.id, $event)" class="btn btn-outline-danger">votekick</button>
                                        <span v-else  class="text-secondary">supreme</span>
                                    </li>
                                </ul>
                            </div>
                        </b-tab>
                        <b-tab title="Invite a new user">
                            <div class="md-form mt-0">
                                <input v-model="searchText" @keyup.enter="searchUser" autocomplete="off" name="search" class="form-control" type="text" placeholder="Search" aria-label="Search">
                                <ul class="list-group" v-if="this.users.length != 0">
                                    <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(user, index) in users" :key="index">
                                        {{ user.name }}
                                        <span v-if="user.inGroup == true"  class="text-secondary">in group</span>
                                        <button @click="invite(user.id, $event)" class="btn btn-outline-success" v-else-if="user.invited == false">Invite</button>
                                        <span class="btn btn-outline-info" v-else>Invited</span>
                                    </li>
                                </ul>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['group','auth_user'],

        data() {
            return {
                name: '',
                status: null,
                searchText: '',
                users: []
            }
        },

        created() {
            console.log(this.group.users);
        },

        methods: {
            updateGroup(event) {
                event.preventDefault();
                axios.put('/updateGroup', {name: this.name, status: this.status, group_id: this.group.id}).then(response => {
                    alert('success')
                });
            },
            deleteGroup(event) {
                event.preventDefault();
                swal({
                    title: "Delete this group?",
                    text: "Are you sure? You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete it!",
                    closeOnConfirm: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.put('/deleteGroup', {group_id: this.group.id}).then(response => {
                            if (response.data.status == 'success') {
                                swal("Poof! Your imaginary group has been deleted!", {
                                    icon: "success",
                                }).then(() => {
                                    window.location.href = '/myGroups/';
                                });
                            }
                        });
                    } else {
                        swal("Your imaginary group is safe!");
                    }
                });
            },
            kickUser(user_id,event) {
                event.preventDefault();
                swal({
                    title: "Delete this user?",
                    text: "Are you sure? You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, kick him!",
                    closeOnConfirm: true
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            axios.put('/kickUser', {user_id: user_id, group_id: this.group.id}).then(response => {
                                if (response.data.status == 'success') {
                                    swal("Poof! Your imaginary user has been deleted!", {
                                        icon: "success",
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                        } else {
                            swal("Your imaginary user is safe!");
                        }
                    });
            },
            searchUser() {
                axios.post('/searchUser', {text: this.searchText, group_id: this.group.id, user_id: this.auth_user.id}).then(response => {
                    this.users = response.data.users;
                });
            },
            invite(user_id, event) {
                axios.post('/inviteUser', {user_id: user_id, group_id: this.group.id}).then(response => {
                    if (response.data.status == 'success') {
                        let sp1 = document.createElement("span");
                        sp1.setAttribute("class", "btn btn-outline-info");
                        let sp1_content = document.createTextNode("Invited");
                        sp1.appendChild(sp1_content);
                        event.target.parentNode.replaceChild(sp1, event.target)
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>