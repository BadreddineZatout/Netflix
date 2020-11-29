<template>
    <div v-if="componentLoader" class="position-relative h-100">
        <app-overlay-loader/>
    </div>
    <div v-else>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-11">
                <draggable tag="div"
                           v-model="socialLinks"
                           v-bind="dragOptions"
                           @start="dragstart($event)"
                           @end="dragend"
                           @change="change">
                    <app-pre-loader v-if="!isActive"/>
                    <div
                        class="d-flex flex-wrap flex-column flex-lg-row align-items-lg-center justify-content-between py-half-primary"
                        v-else
                        v-for="(socialLink, index) in socialLinks"
                        :key="'social-link'+index">
                        <div class="d-flex align-items-center">
                            <app-icon name="menu" class="mr-3 cursor-grab"/>
                            <div class="avatars-w-40 mr-3">
                                <div class="no-img rounded-circle shadow">
                                    <span :key="socialLink.icon">
                                        <app-icon :name="socialLink.icon" width="19px" height="19"/>
                                    </span>
                                </div>
                            </div>
                            <p class="mb-0">{{ $t(socialLink.name) }}</p>
                        </div>
                        <div class="mt-2 mt-lg-0">
                            <div v-if="socialLink.link && !socialLink.edit"
                                 :key="'with-link-'+index"
                                 class="d-flex align-items-center text-muted" style="max-width: 310px;">
                                <p class="mb-0 mr-2 text-truncate">{{socialLink.link}}</p>
                                <a href="#"
                                   class="text-muted"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   :title="$t('remove_link')"
                                   @click.prevent="removeSocialLink(index)">
                                    <app-icon name="trash"/>
                                </a>
                            </div>
                            <div v-else
                                 :key="'without-link-'+index">
                                <div v-if="socialLink.edit"
                                     :key="'without-link-edit-'+index"
                                     class="d-flex align-items-center">
                                    <app-input :id="'social-link-'+index"
                                               class="mr-2"
                                               type="text"
                                               v-model="socialLink.link"/>
                                    <button type="submit"
                                            class="btn btn-primary mr-2"
                                            @click.prevent="addSocialLink(index)">
                                        {{ $t('add') }}
                                    </button>
                                    <a href="#" class="text-muted" @click.prevent="editToggle(index)">
                                        <app-icon name="x"/>
                                    </a>
                                </div>
                                <div v-else
                                     :key="'without-link-show-'+index"
                                     class="text-lg-right">
                                    <button type="submit" class="btn btn-primary"
                                            @click.prevent="editToggle(index)">
                                        {{$t('link') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    import {FormMixin} from "../../../../core/mixins/form/FormMixin";
    import GlobalHelperMixin from "../../../Mixins/global/GlobalHelperMixin";
    import {UserMixin} from "./mixins/UserMixin";
    import {CHANGE_SOCIAL_LINKS} from "../../../config/ApiUrl";

    export default {
        name: "SocialLinks",
        components: {draggable},
        mixins: [FormMixin, UserMixin, GlobalHelperMixin],
        data() {
            return {
                isActive: false,
                socialLinks: []
            }
        },
        mounted() {
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip();
            }, 5000);
        },
        watch:{
            'user.socialLinks':{
                handler: 'setSocialLinks',
                immediate: true
            },
            componentLoader: function (value) {
                if (value==false){
                    setTimeout(() => {
                        let position = parseInt(localStorage.getItem('profileScrollPosition'));
                        if (position){
                            window.scroll({
                                top: position,
                                left: 0,
                                behavior: 'smooth'
                            });
                        }
                        localStorage.removeItem('profileScrollPosition');
                    });
                }
            }
        },
        computed: {
            dragOptions() {
                return {
                    animation: 300
                };
            }
        },
        methods: {
            setSocialLinks(){
                this.isActive = false;
                this.socialLinks = [...this.user.socialLinks];
                this.isActive = true;
            },
            editToggle(index) {
                this.isActive = false;
                this.socialLinks[index].edit = !this.socialLinks[index].edit;
                this.isActive = true;
                setTimeout(()=>{
                    $('#social-link-'+index).focus();
                });
            },
            removeSocialLink(index) {
                this.isActive = false;
                this.socialLinks[index].link = null;
                this.isActive = true;
                this.update(this.socialLinks[index]);
            },
            addSocialLink(index) {
                this.isActive = false;
                this.socialLinks[index].edit = false;
                this.isActive = true;
                this.update(this.socialLinks[index]);
            },
            update(data) {
                localStorage.setItem('profileScrollPosition',window.scrollY+'');
                const url = CHANGE_SOCIAL_LINKS;
                this.axiosPost({
                    url,
                    data
                }).then(res => {
                    this.$toastr.s(res.data.message);
                    location.reload();
                }).catch(err => {
                    this.$toastr.s(err.data.message);
                })
            },
            dragstart(ev) {
                this.drag = true;
                ev.target.classList.add('catch-container');
                ev.item.classList.add('catch-item');
            },
            dragend(ev) {
                this.drag = false;
                ev.target.classList.remove('catch-container');
                ev.item.classList.remove('catch-item');
            },
            change() {
            },
        }
    }
</script>

<style scoped>
    .catch-item {
        background: var(--base-color) !important;
    }
</style>
