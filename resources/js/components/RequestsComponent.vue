<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Requests</div>

                <div class="card-body">
                    <ul class="list-group" v-if="this.requests.length != 0">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(request, index) in this.requests" :key="index">
                            <span>Request from <strong>{{ request.from_user.name }}</strong> to <strong>{{ request.group.name }} </strong></span>
                            <div class="d-flex justify-content-around align-items-center">
                                <button @click="confirm(request.id, request.group.id , $event)" type="button" class="btn btn-outline-success">Confirm</button>
                                <button @click="deleteReq(request.id, request.group.id , $event)" type="button" class="btn btn-outline-danger">Delete</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['requests'],

        data() {
            return {
            }
        },

        created() {
        },

        methods: {
            deleteReq(request_id, group_id, event) {
                event.preventDefault();
                swal({
                    title: "Delete this invite?",
                    text: "Are you sure? You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete it!",
                    closeOnConfirm: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.put('/requests/delete', {request_id: request_id, group_id: group_id}).then(response => {
                            if (response.data.status == 'success') {
                                swal("Poof! Request has been deleted!", {
                                    icon: "success",
                                }).then(() => {
                                    window.location.href = '/requests/';
                                });
                            }
                        });
                    } else {
                        swal("Request is safe!");
                    }
                });
            },
            confirm(request_id, group_id, event) {
                event.preventDefault();
                swal({
                    title: "Request this invite?",
                    text: "Are you sure? You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Confirm it!",
                    closeOnConfirm: true
                })
                .then((willConfirm) => {
                    if (willConfirm) {
                        axios.put('/requests/confirm', {request_id: request_id, group_id: group_id}).then(response => {
                            if (response.data.status == 'success') {
                                swal("Poof! Invite has been confirmed!", {
                                    icon: "success",
                                }).then(() => {
                                    window.location.href = '/requests/';
                                });
                            }
                        });
                    } else {
                        swal("Not confirm!");
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>