/**
 * Created by Andrew N on 12/16/2015.
 */
blog.controller('postController', function ($location, $log, blogLog) {
    var pself = this;
    pself.data_loaded = false;
    pself.entry_display = blogLog.get_clicked_post();


    console.log('pself.entry_display is: ', pself.entry_display);
    if(pself.entry_display == false){
        $location.path('/home');
    }


    console.log('pself.entry_display is: ',pself.entry_display);
});