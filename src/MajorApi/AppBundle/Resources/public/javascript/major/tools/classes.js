define([], function () {
    return {
        addClass: function (el, classText) {
            if (el.className.indexOf(classText) === -1) {
                el.className += " " + classText;
            }
        },
        removeClass: function (el, classText) {
            var start = el.className.indexOf(classText);
            if (start !== -1) {
                var newClasses = el.className.substr(0, start) + el.className.substr(start + classText.length);
                el.className = newClasses.trim();
            }
        },
        hasClass: function (el, classText) {
            if (el.className.indexOf(classText) > 0) {
                return true;
            }
            return false;
        }
    };
});