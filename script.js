initMap();

async function initMap() {
    await ymaps3.ready;

    const {YMap, YMapDefaultSchemeLayer} = ymaps3;

    const map = new YMap(
        document.getElementById('map'),
        {
            location: {
                center: [37.588144, 55.733842],
                zoom: 10
            }
        }
    );
        
    map.addChild(new YMapDefaultSchemeLayer());
}
// Создает метку в центре Москвы
var placemark = new YMaps.Placemark(new YMaps.GeoPoint(37.609218,55.753559));

// Устанавливает содержимое балуна
placemark.name = "Москва";
placemark.description = "Столица Российской Федерации";

// Добавляет метку на карту
map.addOverlay(placemark); 

function changeImage(imageName) {
    document.getElementById('mainImage').src = imageName;
}


document.querySelector('html').style.scrollBehavior = 'smooth';

function smoothScroll(element, duration) {
    var target = document.querySelector(element);
    var targetPosition = target.getBoundingClientRect().top;
    var startPosition = window.pageYOffset;
    var distance = targetPosition - startPosition;
    var startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        var timeElapsed = currentTime - startTime;
        var run = ease(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }

    function ease(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
}

document.querySelector('button').addEventListener('click', function() {
    smoothScroll('#about-us', 2000);
});
