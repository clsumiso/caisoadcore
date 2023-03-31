//Vertical form basic
$('#wizard_vertical').steps({
    headerTag: 'h2',
    bodyTag: 'section',
    transitionEffect: 'slideLeft',
    stepsOrientation: 'vertical',
    onInit: function (event, currentIndex) {
        setButtonWavesEffect(event);
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        setButtonWavesEffect(event);
    }
});