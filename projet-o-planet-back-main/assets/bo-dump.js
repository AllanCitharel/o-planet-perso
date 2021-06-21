let boScript = {
    init: function(){
        // currentRow = null;
        // timeOut = null;
        document.addEventListener('click', boScript.handleRowClick);

        // let hoverTimeout = null;

        // document.addEventListener('mousemove', function(e) {

        //     Check hovered element 
        //     boScript.handleRowMouseOver(e);

        //     // reset timer
        //     clearTimeout(timeOut);

        //     /* 
        //     // code to display bubble that doesn't work
        //     // Remove information bubble if it exists
        //     if(document.querySelector('.informationBubble')){
        //         console.log(document.querySelector('.informationBubble'));
        //         boScript.removeInformationBubble();
        //         console.log('info bubble removed');
        //     }
        //     */

        // });

        // document.addEventListener('mouseover', boScript.handleRowMouseOver);

    },
    handleRowClick: function(event){

        let clickedElement = event.target;

        let elementInTableBody = boScript.getParentElement(clickedElement);

        if(elementInTableBody != null){

            let dumpId = boScript.getDumpId(clickedElement);

            let currentPage = window.location.href;
            
            window.location = currentPage + dumpId;
        
        }

    },
    getDumpId: function(element){
        rowElement = element.closest('tr');
        let dumpId = rowElement.id;
        
        return dumpId;
    },
    
    getParentElement: function(target){
        let elementInTableBody = target.closest('tbody');

        return elementInTableBody;
    }
    // handleRowMouseOver: function(event){

    //     let hoveredElement = event.target;

    //     let elementInTableBody = boScript.getParentElement(hoveredElement);

    //     if(elementInTableBody != null){
    //         timeOut = setTimeout(function(){boScript.addInformationBubble(event, hoveredElement)}, 1000);
    //     }
    
    // },

    // addInformationBubble: function(event, hoveredElement){

    //     // boScript.removeInformationBubble();

    //     let dumpId = boScript.getDumpId(hoveredElement);

    //     console.log('test');

    //     if(dumpId != currentRow){
            


    //         console.log('adding new bubble');
    //         currentRow = dumpId;

            
    //         let informationBubble = document.createElement('div');
            
    //         informationBubble.innerText = "Voir la page de détail du dump n°" + dumpId;
            
    //         // console.log(hoveredElement.offSetTop);

    //         informationBubble.style.position = 'absolute';
    //         informationBubble.style.top = event.clientY - 50 + 'px';
    //         informationBubble.style.left = event.clientX - 50 + 'px';
    //         informationBubble.style.width = '200px';
    //         informationBubble.style.height = 'auto';
    //         informationBubble.style.borderRadius = '5px';
    //         informationBubble.style.padding = '10px';
    //         informationBubble.style.textAlign = 'center';
    //         informationBubble.style.color = 'white';
    //         informationBubble.style.fontSize = '0.9rem';

    //         informationBubble.style.backgroundColor = 'grey';
    //         informationBubble.classList.add('informationBubble');
            
            
    //         document.querySelector('body').appendChild(informationBubble);
    //     } 

    //     console.log('info bubble added');
    // },
    // removeInformationBubble: function(){
    //     if(document.querySelector(".informationBubble")){

    //         document.querySelector('body').removeChild(document.querySelector(".informationBubble"));
    //     }

    // },

}


document.addEventListener('DOMContentLoaded', boScript.init);
