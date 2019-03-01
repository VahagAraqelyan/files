import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PartnersRoutingModule } from './partners-routing.module';
import { LoginComponent } from './login/login.component';

import {
  MatIconModule,
  MatButtonModule,
  MatTreeModule,
  MatProgressBarModule,
  MatSidenavModule,
  MatInputModule,
  MatTableModule,
  MatSortModule,
  MatPaginatorModule,
  MatSelectModule
} from '@angular/material';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { DashboardComponent } from './dashboard/dashboard.component';
import { MenuComponent } from './menu/menu.component';

@NgModule({
  declarations: [LoginComponent, DashboardComponent, MenuComponent],
  imports: [
    MatTreeModule,
    MatIconModule,
    MatProgressBarModule,
    MatButtonModule,
    MatSidenavModule,
    MatInputModule,
    MatTableModule,
    MatSortModule,
    MatPaginatorModule,
    MatSelectModule,
    CommonModule,
    PartnersRoutingModule,
    ReactiveFormsModule,
    FormsModule,
  ]
})
export class PartnersModule { }
