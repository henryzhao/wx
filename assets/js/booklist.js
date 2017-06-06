/**
 * Created by Angel on 2017/5/30.
 */
var _pageNo=1;
var _pageSize=3000;
var vm = new Vue({

    el:"#list_table",
    data:{
        books:''
    },
    methods:{

    },
    mounted: function() {
        // alert('a');
        this.$nextTick(function () {
            //alert('b');
            this.$http.get('http://software.whu.edu.cn:8080/quick4j/rest/books/books.json?pageNo='+_pageNo+'&pageSize='+_pageSize).then(function(res) {
                console.log(res.data);
                  //alert('c');
                this.books = res.data;
                console.log(this.booksNumber);
            }).catch(function(err) {
                // console.log('fail' + status + "," + request);
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