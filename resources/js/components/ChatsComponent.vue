<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Messages</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height:300px; overflow-y:scrloll">
                        <li class="p-2">
                            <strong>Harish</strong>
                            dskfjndsjfn
                        </li>
                    </ul>
                </div>

                <input
                     type="text"
                     name="message"
                     placeholder="Enter your message..."
                     class="form-control">

                <span class="text-muted">user is typing...</span>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2">Harish</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
