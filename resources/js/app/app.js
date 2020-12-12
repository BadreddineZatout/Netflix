import Vue from 'vue';
window.moment = require('moment');
//vue-tel-input
import { VueTelInput } from 'vue-tel-input';
//helper app
import './components/helpers/helperApp';

/**
 * all component of GUD
 */
Vue.component('personal-information', require('./components/views/user/PersonalInformation').default);
Vue.component('password-change',  require('./components/views/user/PasswordChange').default);
Vue.component('social-links',  require('./components/views/user/SocialLinks').default);
Vue.component('login',  require('./components/views/auth/Login').default);
Vue.component('password-reset',  require('./components/views/auth/PasswordReset').default);
Vue.component('reset-password',  require('./components/views/auth/ResetPassword').default);
Vue.component('registration',  require('./components/views/auth/Registration').default);
Vue.component('my-profile',  require('./components/views/user/Profile').default);
Vue.component('dashboard-default',  require('./components/views/dashboard/Default').default);
Vue.component('dashboard-panne',  require('./components/views/dashboard/Pannes').default);
Vue.component('dashboard-trans',  require('./components/views/dashboard/Transactions').default);
Vue.component('dashboard-abonnements',  require('./components/views/dashboard/Abonnements').default);
Vue.component('dashboard-chargements',  require('./components/views/dashboard/Chargements').default);
Vue.component('dashboard-revendeur',  require('./components/views/dashboard/Revendeur').default);
Vue.component('dashboard-charge',  require('./components/views/dashboard/Charge').default);
Vue.component('dashboard-settings',  require('./components/views/dashboard/Settings').default);
Vue.component('declare-panne',  require('./components/views/panne/declare-panne').default);

// Settings
Vue.component('app-setting',  require('./components/views/settings/app-settings/Index').default);
Vue.component('general-setting',  require('./components/views/settings/app-settings/GeneralSetting').default);
Vue.component('email-setting',  require('./components/views/settings/app-settings/EmailSetting').default);
Vue.component('sms-setting',  require('./components/views/settings/app-settings/sms-setting/SmsSetting').default);
Vue.component('google-re-captcha-setting',  require('./components/views/settings/app-settings/google-re-captcha-setting/GoogleRecaptchaSetting').default);
Vue.component('notification-settings', require('./components/views/settings/app-settings/notification/settings/Index').default);
Vue.component('database-template', require('./components/views/settings/app-settings/notification/template/DatabaseTemplate').default);
Vue.component('mail-template', require('./components/views/settings/app-settings/notification/template/MailTemplate').default);

// Forms
Vue.component('form-layouts',  require('./components/views/form/form-layouts/FormLayouts').default);
Vue.component('form-grid',  require('./components/views/form/form-layouts/components/FormGrid').default);
Vue.component('form-row',  require('./components/views/form/form-layouts/components/FormRow').default);
Vue.component('form-horizontal',  require('./components/views/form/form-layouts/components/HorizontalForm').default);
Vue.component('form-validation',  require('./components/views/form/form-validation/FormValidationIndex').default);
Vue.component('form-validation-required',  require('./components/views/form/form-validation/component/FormValidationRequired').default);
Vue.component('form-validation-range',  require('./components/views/form/form-validation/component/FormRangeValidation').default);
Vue.component('input-text',  require('./components/views/form/InputText').default);

// All input forms
Vue.component('all-form-inputs',  require('./components/views/form/form-elements/FormElements').default);
Vue.component('form-input-fields',  require('./components/views/form/form-elements/components/FormInput').default);
Vue.component('form-date-time-fields',  require('./components/views/form/form-elements/components/FormDateTimePIcker').default);
Vue.component('form-multi-select-fields',  require('./components/views/form/form-elements/components/FormMultiSelect').default);
Vue.component('form-radio-fields',  require('./components/views/form/form-elements/components/FormRadio').default);
Vue.component('form-files-fields',  require('./components/views/form/form-elements/components/FormFiles').default);
Vue.component('multiple-form-files-fields',  require('./components/views/form/form-elements/components/FormMultipleFiles').default);

// Tables
Vue.component('basic-datatable',  require('./components/views/tables/basic-datatable/index').default);
Vue.component('advance-datatable',  require('./components/views/tables/AdvanceDatatable').default);
Vue.component('responsive-datatable',  require('./components/views/tables/ResponsiveDatatable').default);
Vue.component('datatable-with-filter',  require('./components/views/tables/filter-type-datatable/index').default);
Vue.component('datatable-pagination',  require('./components/views/tables/datatable-pagination/index').default);

// UI Features
Vue.component('icons',  require('./components/views/ui-features/icons/Index').default);
Vue.component('modal',  require('./components/views/ui-features/modals/Modal').default);
Vue.component('buttons',  require('./components/views/ui-features/buttons/Buttons').default);
Vue.component('avatars',  require('./components/views/ui-features/avatars/Avatars').default);
Vue.component('badges',  require('./components/views/ui-features/badges/Badges').default);
Vue.component('error-notes',  require('./components/views/ui-features/error-notes/ErrorNotes').default);
Vue.component('checkboxes-radios',  require('./components/views/ui-features/checkboxes-radios/CheckboxesRadios').default);
Vue.component('cards',  require('./components/views/ui-features/cards/Cards').default);
Vue.component('tabs',  require('./components/views/ui-features/tabs/Tabs').default);
Vue.component('tab-setting',  require('./components/views/ui-features/tabs/components/TabSetting').default);
Vue.component('nothing-to-show',  require('./components/views/ui-features/nothing-to-show/NothingToShow').default);

// Sample Pages
Vue.component('blank-page',  require('./components/views/sample-pages/Blank').default);

// User and Roles
Vue.component('user-roles',  require('./components/views/user-and-roles/Index').default);
Vue.component('group-of-users',  require('./components/views/user-and-roles/roles/GroupOfUsers').default);

// Demo Crud
Vue.component('app-demo-crud',  require('./components/views/tables/demo-crud/Index').default);
Vue.component('app-add-modal',  require('./components/views/tables/demo-crud/AddModal').default);
Vue.component('app-add-modalT',  require('./components/views/tables/demo-crud/AddModalT').default);
Vue.component('app-add-modalP',  require('./components/views/tables/demo-crud/AddModalP').default);
Vue.component('app-edit-panne',  require('./components/views/tables/demo-crud/EditPanne').default);
Vue.component('app-edit-modalite',  require('./components/views/tables/demo-crud/EditModalite').default);
Vue.component('app-edit-produit',  require('./components/views/tables/demo-crud/EditProduit').default);
Vue.component('app-edit-charge',  require('./components/views/tables/demo-crud/EditCharge').default);

//overlay loader
Vue.component('app-overlay-loader', require('../core/components/preloders/OverlayLoader').default);

// Layouts
Vue.component('dashboard-navbar', require('./components/views/layouts/navbar/Index').default);
Vue.component('dashboard-sidebar', require('./components/views/layouts/sidebar/Index').default);

// notifications
Vue.component('all-notification', require('./components/views/notification/Index').default);
