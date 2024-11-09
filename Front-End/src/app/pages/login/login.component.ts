import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { UsuarioService } from '../../services/usuario.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  nome: string = "";
  password: string = "";

  constructor(private router: Router, private usuarioService: UsuarioService) {}

  onSubmit() {
    this.usuarioService.login(this.nome, this.password).subscribe(
      (response: { user_id: { toString: () => string; }; }) => {
        if (response && response.user_id) {
          localStorage.setItem('session_token', response.user_id.toString());
          this.router.navigate(['/']);
        } else {
          alert('Usuario ou senha invalidos.');
        }
      },
      (error: any) => {
        alert('Usuario ou senha invalidos.');
      }
    );
  }
}