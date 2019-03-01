import {Component, AfterViewInit} from '@angular/core';
import {MapLoaderService} from "../../maps/map.loader";

declare var google: any;

@Component({
  selector: 'app-gps-location',
  templateUrl: './gps-location.component.html',
  styleUrls: ['./gps-location.component.scss']
})
export class GpsLocationComponent implements AfterViewInit {
  map: any;
  drawingManager: any;

  constructor() {
  }

  ngAfterViewInit() {
    MapLoaderService.load().then(() => {
      this.drawPolygon();
    });
  }

  drawPolygon() {
    this.map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 52.8757843, lng: -7.3217572},
      zoom: 8
    });

    this.drawingManager = new google.maps.drawing.DrawingManager({
      drawingMode: google.maps.drawing.OverlayType.polyline,
      drawingControl: true,
      drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: ['polyline', 'marker'],
      },
      PolylineOptions: {
        strokeColor: '#FF0000',
      }
    });

    this.drawingManager.setMap(this.map);
    google.maps.event.addListener(this.drawingManager, 'polylinecomplete', (event) => {
      if (event.type === google.maps.drawing.OverlayType.polyline) {
        console.log(event.getPath().getArray());
        alert(event.getPath().getArray());
      }
    });
  }
}
