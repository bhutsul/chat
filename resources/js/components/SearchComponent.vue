<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search</div>

                    <div class="card-body">
                        <div class="md-form mt-0">
                            <input v-model="searchText" @keyup.enter="searchGroups" name="search" class="form-control" type="text" placeholder="Search" aria-label="Search">
                        </div>
                    </div>

                    <ul class="list-group" v-if="this.groups.length != 0">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(group, index) in groups" :key="index">
                            {{ group.name }}
                            <a :href="'/group/' + group.id" class="btn btn-outline-success" v-if="group.has_user  == true && !group.requested">Go</a>
                            <button @click="joinGroup(group.id)" class="btn btn-outline-success" v-else-if="group.status == 1">Join</button>
                            <div class="d-flex justify-content-between align-items-center" v-else-if="group.status == 0">
                                <span class="text-secondary">this group is private</span>
                                <span v-if="group.requested  == true" class="btn btn-outline-info">Requested</span>
                                <button v-on:click="requestGroup(group.id, $event)" v-else class="btn btn-outline-warning">Request</button>
                            </div>
                        </li>
                    </ul>
                    <span class="text-secondary" v-else>no results :(</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user'],

        data() {
            return {
                searchText: '',
                groups: {},
            }
        },

        created() {

        },

        methods: {
            searchGroups() {
                axios.post('/searchGroups', {text: this.searchText}).then(response => {
                    this.groups = response.data.groups;
                });
            },
            joinGroup(group_id) {
                axios.post('/joinGroup', {user_id: this.user.id, group_id: group_id}).then(response => {
                    if (response.data.status == 'success') {
                        window.location.href = '/group/' + group_id;
                    }
                });
            },
            requestGroup: function (group_id, event){
                axios.post('/requestGroup', {user_id: this.user.id, group_id: group_id, confirmed: 0}).then(response => {
                    if (response.data.status == 'success') {
                        let sp1 = document.createElement("span");
                        sp1.setAttribute("class", "btn btn-outline-info");
                        let sp1_content = document.createTextNode("Requested");
                        sp1.appendChild(sp1_content);
                        event.target.parentNode.replaceChild(sp1, event.target)
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>