import { Component, Input, OnInit } from '@angular/core';
import { Livro } from '../../../../model/Livro';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faPen } from '@fortawesome/free-solid-svg-icons';
import { NgClass } from '@angular/common';

@Component({
  selector: 'app-livro-card',
  standalone: true,
  imports: [FontAwesomeModule, NgClass],
  templateUrl: './livro-card.component.html',
  styleUrl: './livro-card.component.css'
})
export class LivroCardComponent implements OnInit {
  faPen = faPen;

  titulo: string = "";
  autor: string = "";
  comentario: string = "";
  nota: number = 0;
  status: string = "";
  urlImagem: string = "";  

  @Input() livro!: Livro;

  ngOnInit(): void {
    this.preencherCard();
  }

  preencherCard() {
    if (this.livro) {
      this.titulo = this.livro.titulo;
      this.autor = this.livro.autor;  
      this.comentario = this.livro.comentario;
      this.nota = this.livro.nota;  
      this.status = this.livro.status;
      this.urlImagem = this.livro.urlimagem;
      console.log(this.livro);  
    } else {
      console.log('Livro is undefined or null');
    }
  }
}

