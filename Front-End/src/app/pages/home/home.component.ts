import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { MatDialog } from '@angular/material/dialog';
import { AdicionarLivroComponent } from './components/adicionar-livro/adicionar-livro.component';
import { SucessoDialogComponent } from './components/sucesso-dialog/sucesso-dialog.component';
import { LivroService } from '../../services/livro.service';
import { LivroCardComponent } from "./components/livro-card/livro-card.component";
import { Livro } from '../../model/Livro';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [LivroCardComponent, CommonModule],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent implements OnInit{


  constructor(private authService: AuthService, private dialog: MatDialog, private livroService: LivroService){}

  livros: Livro[] = [];

  ngOnInit(): void {
    this.preencherLivros();
  }

  preencherLivros(){
    this.livroService.buscarTodosLivrosUsuario().subscribe({
      next: (livros) => {
        this.livros = livros; 
      },
      error: (error) => {
        console.error('Erro ao buscar livros do usuário:', error);
      }
    });
  }

  adicionarLivro() {
    const dialogRef = this.dialog.open(AdicionarLivroComponent, {
      width: '900px',
      data: {}  
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.ngOnInit();
        this.dialog.open(SucessoDialogComponent, {
          data: { message: 'Livro adicionado com sucesso!'}
        });
      }
    });
  }
}

