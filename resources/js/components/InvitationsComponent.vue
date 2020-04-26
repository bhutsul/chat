<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invitations</div>

                <div class="card-body">
                    <ul class="list-group" v-if="this.invitations.length != 0">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(invitation, index) in this.invitations" :key="index">
                            <span>Invitation to <strong>{{ invitation.group.name }}</strong> from <strong>{{ invitation.from_user.name }}</strong></span>
                            <div class="d-flex justify-content-around align-items-center">
                                <button @click="confirm(invitation.id, invitation.group.id, $event)" type="button" class="btn btn-outline-success">Confirm</button>
                                <button @click="deleteInv(invitation.id, invitation.group.id, $event)" type="button" class="btn btn-outline-danger">Delete</button>
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
        props:['invitations'],

        data() {
            return {
            }
        },

        created() {
            console.log(this.invitations);
        },

        methods: {
            deleteInv(invitation_id, group_id, event) {
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
                        axios.put('/invitations/delete', {invitation_id: invitation_id, group_id: group_id}).then(response => {
                            if (response.data.status == 'success') {
                                swal("Poof! Invite has been deleted!", {
                                    icon: "success",
                                }).then(() => {
                                    window.location.href = '/invitations/';
                                });
                            }
                        });
                    } else {
                        swal("Invite is safe!");
                    }
                });
            },
            confirm(invitation_id, group_id, event) {
                event.preventDefault();
                swal({
                    title: "Confirm this invite?",
                    text: "Are you sure? You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Confirm it!",
                    closeOnConfirm: true
                })
                .then((willConfirm) => {
                    if (willConfirm) {
                        axios.put('/invitations/confirm', {invitation_id: invitation_id, group_id: group_id}).then(response => {
                            if (response.data.status == 'success') {
                                swal("Poof! Invite has been confirmed!", {
                                    icon: "success",
                                }).then(() => {
                                    window.location.href = '/invitations/';
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