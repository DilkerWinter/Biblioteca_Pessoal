import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-sucesso-dialog',
  standalone: true,
  imports: [],
  templateUrl: './sucesso-dialog.component.html',
  styleUrl: './sucesso-dialog.component.css'
})
export class SucessoDialogComponent {
  constructor(
    public dialogRef: MatDialogRef<SucessoDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { message: string }
  ) {}

  onNoClick(): void {
    this.dialogRef.close();
  }
}
