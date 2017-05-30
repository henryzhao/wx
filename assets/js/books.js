/**
 * Created by Angel on 2017/5/30.
 */

var vm = new Vue({

    el:"#home_table",
    data:{
        booksNumber:''
    },
    methods:{

    },
    mounted: function() {
        alert('a');
        this.$nextTick(function () {
            //alert('b');
            this.$http.get('http://221.180.249.233:8888/quick4j/rest/books/number').then(function(res) {
                console.log(res.data);
                  alert('c');
                this.booksNumber = res.data;
            }).catch(function(err) {
                console.log('fail' + status + "," + request);
                console.log(err);
            })
        })
    },


});
// function newOrders(orders, queryParams){
//
//     var newOrders = [];
//     // alert('a');
//     if(queryParams.tel===""){
//         // alert('b');
//         return orders;
//     }
//     // alert('c');
//     $.each(orders,function(index, value){
//         // alert('d');
//         if(value.tel===queryParams.tel){
//             // alert('e');
//             //满足条件的push进返回数组
//             newOrders.push(value);
//         }
//     });
//
//     return newOrders;
//
// }