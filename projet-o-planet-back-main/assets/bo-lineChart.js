let boLineChart = {
    init: function(){
        document.querySelector('#dayLimit').addEventListener('change', boLineChart.sendGetRequest);
    },
    sendGetRequest: function(event){
        $dayLimit = event.target.value;

        let currentPage = window.location;

        console.log(window.location.search);

        window.location.search = '?dayLimit=' + $dayLimit;

    }
}

document.addEventListener('DOMContentLoaded', boLineChart.init);