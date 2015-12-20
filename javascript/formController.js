blog.controller('formController', function($log, blogLog){
    var fself = this;

    fself.call_add_entry = function(){
        $log.info('this.entry is: ', this.entry);
        blogLog.add_entry(this.entry);
        //clear form after adding student
        this.entry = {};
    }
});