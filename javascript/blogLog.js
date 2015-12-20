blog.service('blogLog', function($http, $log, $q){
    var self = this;
    self.entry_arr = [
        //{
        //    "id": 897,
        //    "uid": 755,
        //    "ts": 1450208405,
        //    "title": "The title of your blog",
        //    "summary": "This is the short form of the entry. It could be all new or a truncated version of the full text",
        //    "tags": ["blog", "cats", "fun"],
        //    "public": true,
        //    "published": "2015-12-15 19:40:05",
        //    "edited": "2015-12-08 19:40:05"
        //},
        //{
        //    "id": 897,
        //    "uid": 755,
        //    "ts": 1450208405,
        //    "title": "Dummy Data",
        //    "summary": "Cool Summary",
        //    "tags": ["blog", "cats", "fun"],
        //    "public": true,
        //    "published": "2015-12-15 19:40:05",
        //    "edited": "2015-12-08 19:40:05"
        //}
    ];
    self.data_loaded = false;
    self.entry_display = {};

    self.get_results = function(){
        return self.entry_arr;
    }

    self.get_clicked_post = function(){
        if(angular.equals(self.entry_display, {})){
            return false;
        }else{
            return self.entry_display;
        }
    }

    self.load_data = function(){

        var d = $q.defer();

        if(!self.data_loaded) {
            $http({
                url: 'http://localhost:8888/lfz/Blog/php/listBlogPost.php',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                method: 'POST'
            }).success(function (response) {
                $log.info('load data successful: ', response);
                for(var index in response['data']){
                    self.entry_arr.push(response['data'][index]);
                }
                $log.info('self.entry_arr after data push is: ', self.entry_arr);
                self.data_loaded = true;
                d.resolve(self.entry_arr);
            }).error(function () {
                $log.error('Error loading data');
                d.reject('Error loading data');
            })
        }else{
            $log.info('load data called after initial load. entry_arr: ', self.entry_arr);
        }

        return d.promise;
    }

    self.add_entry = function(entry){
        var data = $.param({
            'title': entry.title,
            'blog': entry.blog,
            //'tags': entry.tags,
            'username': entry.username
        });

        return $http({
            url: 'http://localhost:8888/lfz/Blog/php/createBlogPost.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST',
            data: data
        }).success(function(response){
            console.log(response);
            if(response['success']){
                $log.info('success');
                //$log.error('response.data is: ', response.data);
                entry.id = response.data.id;

                entry.summary = response.data.summary;
                entry.timeStamp = response.data.timeStamp;
                console.log('entry in success is: ', entry);
                console.log('entry_arr is: ', self.entry_arr);

                self.entry_arr.push(entry);
            }else{
                $log.error('Error adding entry to database. response is: ', response);
            }
        }).error(function(){
            $log.error('Error adding entry to database');
        })
    }

    self.delete_entry = function(entry){
        $log.info('delete entry called');

        var data = $.param({
            'id' : entry.id
            //'public': false
        });

        return $http({
            url: 'http://localhost:8888/lfz/Blog/php/deleteBlogPost.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST',
            data: data,
            dataType: 'json',
        }).success( function(response){
            console.log("DEL Response", response);
            if(response.success){
                $log.log("success!!");
                $log.info(response.msg);
                var index = self.entry_arr.indexOf(response.id);
                self.entry_arr.splice(index, 1);
            }
            else{
                $log.log("Not success");
                $log.error(response.error, response);
            }
        }).error(function(){
            $log.error('Error deleting entry from database');
        })
    }

    self.update_entry = function(old_entry, new_entry){
        $log.info('update entry called');
        $log.info('old entry passed into update is: ', old_entry);
        $log.info('old entry passed into update is: ', new_entry);

        var data = $.param({
            id : old_entry.id,
            auth_token: old_entry.auth_token,
            title : new_entry.title,
            blog: new_entry.blog,
            'public': true
        });

        return $http({
            url: 'http://localhost:8888/lfz/Blog/php/updateBlogPost.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST',
            data: data
        }).success(function(response){
            console.log(response);
            if(response['success']){
                $log.info('entry successfully updated in db');
                new_entry.timeStamp = response.data.timeStamp;
                new_entry.summary = response.data.summary;
                var entry_index = self.entry_arr.indexOf(old_entry);
                if(entry_index !== -1){
                    $log.info('entry_arr index is: ', entry_index);
                    self.entry_arr.splice(entry_index, 1, new_entry);
                }
            }
            else{
                $log.error('Error updating entry in database. response is: ', response);
            }
        }).error(function(){
            $log.error('Error updating entry in database');
        })
    }

    self.relay_link_data = function(entry){
        console.log('relay_link_data called in blogLog');
        self.entry_display = entry;
    }

    self.find_user_specific_data = function(user){
        var output_arr = [];
        for(var index in self.entry_arr){
            if(self.entry_arr[index].uid == user){
                output_arr.push(self.entry_arr[index]);
            }
        }
        return output_arr;
    }
})

