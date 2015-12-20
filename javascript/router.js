/**
 * Created by Andrew N on 12/16/2015.
 */

blog.config(function($routeProvider){
    $routeProvider

        .when('/home', {
            templateUrl: 'main_page.html'
        })
        .when('/post', {
            templateUrl: 'post_template.html',
            controller: 'postController',
            controllerAs: 'pc'
        })
        .when('/about', {
            templateUrl: 'about.html',
            controller: 'aboutController',
            controllerAs: 'ac'
        })
        .when('/contact', {
            templateUrl: 'contact.html'
        })
        .otherwise({
            redirectTo: '/home'
        })
});