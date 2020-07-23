<template>
    <div>
        <li class="dropdown" v-if="notifications.length">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell"></i>
            </a>

            <ul class="dropdown-menu">
                <li v-for="notification in notifications">
                    <a :href="notification.data.link" @click="markAsRead(notification)">{{notification.data.message}}</a>
                </li>
            </ul>
        </li>
    </div>
</template>

<script>
    export default{

        data() {
            return {
                notifications: [],
            }
        },

        created() {
            console.log(window.user_name);
            axios.get("/profiles/" + window.user_name + "/notifications")
                .then(response => this.notifications = response.data);
        },
        
        methods: {
            markAsRead(notification) {
                axios.delete("/profiles/" + window.user_name + "/notifications/" + notification.id)
            }
        }
    }
</script>