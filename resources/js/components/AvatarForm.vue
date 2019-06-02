<template>
    <div>
        <div class="level">
            <img :src="avatar" height="50" width="50" class="mr-3">

            <h1 v-text="user.name"></h1>
        </div>

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
<!--            <input type="file" name="avatar" accept="image/*" @change="onChange">-->

<!--            <button type="submit" class="btn btn-primary">Add Avatar</button>-->
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload';

    export default {
        name: "AvatarForm",

        components: { ImageUpload },

        props: ['user'],

        data() {
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id == this.user.id);    // signed in user id == profile user id
            }
        },

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>
