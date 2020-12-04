<template>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-8">
                <div class="back-image"
                     :style="'background-image: url('+configData.company_banner+')'">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 pl-md-0">
                <div class="login-form d-flex align-items-center">
                    <form class="sign-in-sign-up-form w-100" ref="form" data-url="/user/confirm" action="store">
                        <div class="text-center mb-4">
                            <img :src="configData.company_logo?configData.company_logo:'/images/core.png'" alt=""
                                 class="img-fluid logo">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <h6 class="text-center mb-0">{{ $t('sign_up') }}</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_first_name">{{ $t('first_name') }}</label>
                                <app-input type="text"
                                           v-model="user.first_name"
                                           :placeholder="$t('enter_first_name')"
                                           :required="true"
                                />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_last_name">{{ $t('last_name') }}</label>
                                <app-input type="text"
                                           v-model="user.last_name"
                                           :placeholder="$t('enter_last_name')"
                                           :required="true"
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_email">{{ $t('email') }}</label>
                                <app-input type="text"
                                           v-model="user.email"
                                           :placeholder="$t('enter email')"
                                           :required="true"
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_telephone">{{ $t('telephone') }}</label>
                                <app-input type="text"
                                           v-model="user.telephone"
                                           :placeholder="$t('enter telephone')"
                                           :required="true"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-12">
                                <label for="wilayachoice">{{ $t('Wilaya') }}</label>
                                <select id="wilayachoice" name="wilayachoice" class="form-control overflow-auto btn" v-model="user.wilaya" required>
                                    <option value="0" selected> Choisir la Wilaya</option>
                                    <option v-for="wilaya in wilayas" v-bind:key="wilaya.CodeWilaya" :value="wilaya.CodeWilaya" v-on:click="getCommune(wilaya.CodeWilaya)">{{wilaya.NomWilaya}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-12">
                                <label for="commune">{{ $t('Commune') }}</label>
                                <select id="communechoice" name="communechoice" class="form-control overflow-auto btn" v-model="user.commune" required>
                                    <option value="0" selected> Choisir la Commune</option>
                                    <option v-for="commune in communes" v-bind:key="commune.id" :value="commune.id">{{commune.NomCommune}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_adresse">{{ $t('adresse') }}</label>
                                <app-input type="text"
                                           v-model="user.adresse"
                                           :placeholder="$t('enter adresse')"
                                           :required="true"
                                />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_password">{{ $t('password') }}</label>
                                <app-input type="password"
                                           v-model="user.password"
                                           :specialValidation="true"
                                           :placeholder="$t('enter_your_password')"
                                           :required="true"
                                />
                                <PasswordWarning/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="user_password_confirmation">{{ $t('confirm_password') }}</label>
                                <app-input type="password"
                                           same-as="user_password"
                                           v-model="user.password_confirmation"
                                           :placeholder="$t('confirm_password')"
                                           :required="true"
                                />
                            </div>

                        </div>
                        <div class="form-row" v-if="recaptchaEnable == 1">
                            <div class="form-group col-12 px-0">
                                <re-captcha :site-key="siteKey"></re-captcha>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <app-load-more :preloader="preloader"
                                               :label="$t('sign_up')"
                                               :class="{'disabled': false}"
                                               type="submit"
                                               class-name="btn btn-primary btn-block text-center"
                                               @submit="submit"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <p class="text-center mt-5">
                                    {{ $t('copyright_text') + configData.company_name }}
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ThemeMixin from "../../../../core/mixins/global/ThemeMixin";
    import PasswordWarning from './PasswordWarning';
    import {AuthMixin} from "./mixins/AuthMixin";

    export default {
        name: "Registration",
        mixins: [AuthMixin, ThemeMixin],
        components: {
            PasswordWarning
        },
        props: {
            userInfo: {},
            siteKey: String,
            recaptchaEnable: {},
        },
        data() {
            return {
                wilayas: [],
                communes: [],
                user: {
                    wilaya: 0,
                    commune: 0
                },
                userData: {},
            }
        },
        created() {
            this.getWilaya();
            if (this.userInfo) {
                this.userData = JSON.parse(this.userInfo);
            }
        },
        methods: {
            getWilaya(){
                let url = 'default-dashboard-wilayas';
                    this.axiosGet(url).then(response =>{
                        this.wilayas = response.data;    
                    });
            },
            getCommune(id){
                let url = `default-dashboard-communes/communget=${id}`;
                    this.axiosGet(url).then(response =>{
                        this.communes = response.data;    
                    });
            },
            submit() {
                let data = this.user;
                data.invitation_token = this.userData.invitation_token;
                this.savePost('/comptes',data);
                //this.save(data);
            },
            afterSuccess(res) {
                //this.$toastr.s(res.data.message);
                location.replace('/admin/dashboard');
            },
        }

    }
</script>
