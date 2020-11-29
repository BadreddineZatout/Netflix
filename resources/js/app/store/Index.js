import settings from './modules/settings/Settings';
import user from './modules/user/User';
import theme from './modules/theme/Theme';
import userAndRoles from './modules/users-and-roles/UsersAndRoles';
import notificationSettings from './modules/notification-settings/NotificationSettings';

export default{

    modules: {
        theme,
        settings,
        user,
        userAndRoles,
        notificationSettings
    }
}
