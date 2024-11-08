import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor() {}

  public isAuthenticated(): boolean {
    return !!localStorage.getItem('session_token');
  }

  public getSessionToken(): string | null {
    return localStorage.getItem('session_token');
  }

  public logout(): void {
    localStorage.removeItem('session_token');
  }
}
