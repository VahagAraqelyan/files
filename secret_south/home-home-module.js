(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["home-home-module"],{

/***/ "./src/app/home/home-routing.module.ts":
/*!*********************************************!*\
  !*** ./src/app/home/home-routing.module.ts ***!
  \*********************************************/
/*! exports provided: HomeRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomeRoutingModule", function() { return HomeRoutingModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "./node_modules/tslib/tslib.es6.js");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _main_main_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./main/main.component */ "./src/app/home/main/main.component.ts");




var routes = [
    { path: '', component: _main_main_component__WEBPACK_IMPORTED_MODULE_3__["MainComponent"] },
];
var HomeRoutingModule = /** @class */ (function () {
    function HomeRoutingModule() {
    }
    HomeRoutingModule = tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"]([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
            imports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"].forChild(routes)],
            exports: [_angular_router__WEBPACK_IMPORTED_MODULE_2__["RouterModule"]]
        })
    ], HomeRoutingModule);
    return HomeRoutingModule;
}());



/***/ }),

/***/ "./src/app/home/home.module.ts":
/*!*************************************!*\
  !*** ./src/app/home/home.module.ts ***!
  \*************************************/
/*! exports provided: HomeModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomeModule", function() { return HomeModule; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "./node_modules/tslib/tslib.es6.js");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
/* harmony import */ var _home_routing_module__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./home-routing.module */ "./src/app/home/home-routing.module.ts");
/* harmony import */ var _main_main_component__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./main/main.component */ "./src/app/home/main/main.component.ts");
/* harmony import */ var _agm_core__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @agm/core */ "./node_modules/@agm/core/index.js");
/* harmony import */ var _angular_material__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/material */ "./node_modules/@angular/material/esm5/material.es5.js");







var HomeModule = /** @class */ (function () {
    function HomeModule() {
    }
    HomeModule = tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"]([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"])({
            declarations: [_main_main_component__WEBPACK_IMPORTED_MODULE_4__["MainComponent"]],
            imports: [
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatTreeModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatIconModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatProgressBarModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatButtonModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatSidenavModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatInputModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatTableModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatSortModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatPaginatorModule"],
                _angular_material__WEBPACK_IMPORTED_MODULE_6__["MatSelectModule"],
                _angular_common__WEBPACK_IMPORTED_MODULE_2__["CommonModule"],
                _home_routing_module__WEBPACK_IMPORTED_MODULE_3__["HomeRoutingModule"],
                _agm_core__WEBPACK_IMPORTED_MODULE_5__["AgmCoreModule"].forRoot({
                    apiKey: 'AIzaSyCgUl40xKEjDAAJNWZHMZqWajSOd25yJOs',
                    libraries: ['places'],
                }),
            ]
        })
    ], HomeModule);
    return HomeModule;
}());



/***/ }),

/***/ "./src/app/home/main/main.component.html":
/*!***********************************************!*\
  !*** ./src/app/home/main/main.component.html ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n<div class=\"col-12\" *ngIf=\"latlng.length>0\">\n\n  <div class=\"form-group\">\n    <mat-form-field class=\"example-full-width\" >\n      <mat-select placeholder=\"Search By\" name=\"searchBy\"  [(value)]=\"searchBy.type\"  (selectionChange)=\"changePlace()\">\n        <mat-option value=\"1\">Ferry</mat-option>\n        <mat-option value=\"2\">Food/Drink</mat-option>\n        <mat-option value=\"3\">Tours</mat-option>\n      </mat-select>\n    </mat-form-field>\n  </div>\n\n  <agm-map [latitude]=\"lat\" [longitude]=\"lng\" style=\"height:600px;\">\n    <agm-marker *ngFor=\"let single of latlng\" [latitude]=\"single.lat\" [longitude]=\"single.lng\">\n      <agm-info-window *ngIf=\"searchBy.type==1 || searchBy.type==0\">\n      <h4>{{single.name}}</h4>\n        <div class=\"info\">\n          <p><span>Max:</span><span>{{single.max_people}} people</span></p>\n          <p><span>Min:</span><span>{{single.min_people}} people</span></p>\n          <p><span>Tel:</span><span>{{single.phone}}</span></p>\n        </div>\n        <button onclick=\"\" mat-raised-button color=\"primary\">Book</button>\n      </agm-info-window>\n\n      <agm-info-window class=\"infWindow\" *ngIf=\"searchBy.type==2\">\n        <div class=\"info\">\n          <h4>{{single.name}}</h4>\n          <img class=\"infowindowImg\" src=\"{{imgPath+'uploads/food_drink/'+single.img}}\" alt=\"\">\n          <p><span>Description:</span><span>{{single.description}}</span></p>\n          <p><span>Address:</span><span>{{single.address}}</span></p>\n          <button onclick=\"\" mat-raised-button color=\"primary\">Book</button>\n        </div>\n      </agm-info-window>\n\n      <agm-info-window class=\"infWindow\" *ngIf=\"searchBy.type==3\">\n        <div class=\"info\">\n          <h4>{{single.name}}</h4>\n          <img class=\"infowindowImg\" src=\"{{imgPath+'uploads/tour/'+single.img}}\" alt=\"\">\n          <p><span>Description:</span><span>{{single.description}}</span></p>\n          <p><span>Address:</span><span>{{single.address}}</span></p>\n          <button onclick=\"\" mat-raised-button color=\"primary\">Book</button>\n        </div>\n      </agm-info-window>\n    </agm-marker>\n  </agm-map>\n</div>\n\n"

/***/ }),

/***/ "./src/app/home/main/main.component.scss":
/*!***********************************************!*\
  !*** ./src/app/home/main/main.component.scss ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".agm-info-window-content {\n  max-width: 400px; }\n\n.info {\n  width: 50%;\n  margin: 0 auto;\n  display: block;\n  font-size: 17px;\n  font-weight: 500; }\n\n.info img.infowindowImg {\n    width: 100%; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9hcHAvaG9tZS9tYWluL0M6XFx3YW1wNjRcXHd3d1xcc2VjcmV0X3NvdXRoXFxmcm9udC9zcmNcXGFwcFxcaG9tZVxcbWFpblxcbWFpbi5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLGdCQUNGLEVBQUE7O0FBRUE7RUFDRSxVQUFVO0VBQ1YsY0FBYztFQUNkLGNBQWM7RUFDZCxlQUFlO0VBQ2YsZ0JBQWdCLEVBQUE7O0FBTGxCO0lBUUksV0FBVyxFQUFBIiwiZmlsZSI6InNyYy9hcHAvaG9tZS9tYWluL21haW4uY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIuYWdtLWluZm8td2luZG93LWNvbnRlbnR7XHJcbiAgbWF4LXdpZHRoOjQwMHB4XHJcbn1cclxuXHJcbi5pbmZvIHtcclxuICB3aWR0aDogNTAlO1xyXG4gIG1hcmdpbjogMCBhdXRvO1xyXG4gIGRpc3BsYXk6IGJsb2NrO1xyXG4gIGZvbnQtc2l6ZTogMTdweDtcclxuICBmb250LXdlaWdodDogNTAwO1xyXG5cclxuICBpbWcuaW5mb3dpbmRvd0ltZyB7XHJcbiAgICB3aWR0aDogMTAwJTtcclxuICB9XHJcbn1cclxuIl19 */"

/***/ }),

/***/ "./src/app/home/main/main.component.ts":
/*!*********************************************!*\
  !*** ./src/app/home/main/main.component.ts ***!
  \*********************************************/
/*! exports provided: MainComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MainComponent", function() { return MainComponent; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "./node_modules/tslib/tslib.es6.js");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _agm_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @agm/core */ "./node_modules/@agm/core/index.js");
/* harmony import */ var _services_main_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../services/main.service */ "./src/app/home/services/main.service.ts");
/* harmony import */ var _config_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../config.js */ "./src/app/config.js");
/* harmony import */ var _config_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_config_js__WEBPACK_IMPORTED_MODULE_4__);





var MainComponent = /** @class */ (function () {
    function MainComponent(mapsAPILoader, ngZone, main) {
        this.mapsAPILoader = mapsAPILoader;
        this.ngZone = ngZone;
        this.main = main;
        this.lat = 0;
        this.lng = 0;
        this.latlng = [];
        this.searchBy = { 'type': '' };
        this.imgPath = '';
        this.successData = false;
    }
    MainComponent.prototype.ngOnInit = function () {
        this.imgPath = _config_js__WEBPACK_IMPORTED_MODULE_4__["imgPath"];
        this.getFerryLocation();
    };
    MainComponent.prototype.getFerryLocation = function () {
        var _this = this;
        this.latlng = this.main.getFerryLocation().subscribe(function (r) {
            if (r.status == 0) {
                alert(r['message']);
                return false;
            }
            var arr = [];
            r['result'].map(function (latlngs) {
                latlngs.lat = parseFloat(latlngs.lat);
                latlngs.lng = parseFloat(latlngs.lng);
                arr.push(latlngs);
            });
            _this.latlng = arr;
            _this.lat = parseFloat(_this.latlng[0].lat);
            _this.lng = parseFloat(_this.latlng[0].lng);
            _this.successData = true;
        });
    };
    MainComponent.prototype.changePlace = function () {
        var _this = this;
        this.main.changePlace(this.searchBy).subscribe(function (r) {
            if (r.status == 0) {
                alert(r['message']);
                return false;
            }
            var arr = [];
            r['result'].map(function (latlngs) {
                latlngs.lat = parseFloat(latlngs.lat);
                latlngs.lng = parseFloat(latlngs.lng);
                arr.push(latlngs);
            });
            _this.latlng = arr;
            _this.lat = parseFloat(_this.latlng[0]['lat'].lat);
            _this.lng = parseFloat(_this.latlng[0].lng);
            _this.successData = true;
        });
    };
    tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"]([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ViewChild"])('addSearch'),
        tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"]("design:type", _angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"])
    ], MainComponent.prototype, "searchelementRef", void 0);
    MainComponent = tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"]([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Component"])({
            selector: 'app-main',
            template: __webpack_require__(/*! ./main.component.html */ "./src/app/home/main/main.component.html"),
            styles: [__webpack_require__(/*! ./main.component.scss */ "./src/app/home/main/main.component.scss")]
        }),
        tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"]("design:paramtypes", [_agm_core__WEBPACK_IMPORTED_MODULE_2__["MapsAPILoader"], _angular_core__WEBPACK_IMPORTED_MODULE_1__["NgZone"], _services_main_service__WEBPACK_IMPORTED_MODULE_3__["MainService"]])
    ], MainComponent);
    return MainComponent;
}());



/***/ }),

/***/ "./src/app/home/services/main.service.ts":
/*!***********************************************!*\
  !*** ./src/app/home/services/main.service.ts ***!
  \***********************************************/
/*! exports provided: MainService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MainService", function() { return MainService; });
/* harmony import */ var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! tslib */ "./node_modules/tslib/tslib.es6.js");
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _config_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../config.js */ "./src/app/config.js");
/* harmony import */ var _config_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_config_js__WEBPACK_IMPORTED_MODULE_3__);




var MainService = /** @class */ (function () {
    function MainService(http) {
        this.http = http;
    }
    MainService.prototype.getFerryLocation = function () {
        var httpOptions = {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_2__["HttpHeaders"]({
                'content-type': 'application/json',
            })
        };
        return this.http.get(_config_js__WEBPACK_IMPORTED_MODULE_3__["url"] + '/home/get_places', httpOptions);
    };
    MainService.prototype.changePlace = function (data) {
        var httpOptions = {
            headers: new _angular_common_http__WEBPACK_IMPORTED_MODULE_2__["HttpHeaders"]({
                'content-type': 'application/json',
            })
        };
        return this.http.post(_config_js__WEBPACK_IMPORTED_MODULE_3__["url"] + '/home/check_place', data, httpOptions);
    };
    MainService = tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"]([
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["Injectable"])({
            providedIn: 'root'
        }),
        tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"]("design:paramtypes", [_angular_common_http__WEBPACK_IMPORTED_MODULE_2__["HttpClient"]])
    ], MainService);
    return MainService;
}());



/***/ })

}]);
//# sourceMappingURL=home-home-module.js.map