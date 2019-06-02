<template>
    <div class="alert alert-flash"
         :class="'alert-' + type"
         role="alert"
         v-show="show"
         v-text="body"
    >
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: '',
                type: 'success',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
                // setTimeout(() => {
                //     this.show = false;
                // }, 3000);
            }

            // a global event that will listen for
            // a flash event anywhere on the system
            // here we define the event
            // windows.events is a custom property
            // here window.events = vue (see in bootstrap.js)

            // window.events.$on('flash', message => {
            //     this.flash(message);
            // })
            // Register a global event
            // When the 'flash' event occurs call this.flash() method
            window.events.$on('flash', data => this.flash(data));
        },

        methods: {
            flash(data) {
                this.body = data.message;
                this.type = data.type;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>


<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
