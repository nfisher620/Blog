/**
 * Created by Andrew N on 12/17/2015.
 */
blog.controller('aboutController', function($location, $log, blogLog){
    var acself = this;
    acself.user_posts = [];

    acself.get_current_user_arr = function(){
        return acself.user_posts;
    };

    acself.call_find_user_specific_data = function(user){
        acself.user_posts = blogLog.find_max_or_min(user);
    }

    acself.call_relay_link_data = function(entry){
        blogLog.relay_link_data(entry);
        $location.path('/post');
        console.log('call_relay_link_data called');
    }

    acself.call_remove_entry = function (entry) {
        blogLog.delete_entry(entry);
    }

    acself.call_update_entry = function(old_entry){
        blogLog.update_entry(old_entry, this.entry);
    }
});