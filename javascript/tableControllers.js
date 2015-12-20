blog.controller('tableController', function ($location, $scope, $log, blogLog) {
    var tself = this;
    tself.entry_arr = blogLog.get_results();

    blogLog.load_data()
        .then(function (response) {
            $log.info('response is: ', response);
            tself.entry_arr = response;
            $log.info('tself.entry_arr is now: ', tself.entry_arr);
        }, function () {
            $log.error('Error loading data into tableController');
        }
    );

    tself.call_remove_entry = function (entry) {
        blogLog.delete_entry(entry);
    }

    tself.call_update_entry = function(old_entry){
        blogLog.update_entry(old_entry, this.entry);
    }

    tself.call_relay_link_data = function(entry){
        blogLog.relay_link_data(entry);
        $location.path('/post');
        console.log('call_relay_link_data called');
    }
});