import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HomeComponent } from './pages/home/home.component';
import { AuthGuard } from './Auth.guard';
import { RegistrarComponent } from './pages/registrar/registrar.component';

export const routes: Routes = [
    { path: 'login', component: LoginComponent},
    {path: 'registrar', component: RegistrarComponent},
    { path: '', component: HomeComponent , canActivate: [AuthGuard] },
    { path: '**', redirectTo: '/login' }
];
