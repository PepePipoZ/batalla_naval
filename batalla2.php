<?php
//vaiable del nombre del jugador
$nombre=$_GET['nombre'];
//arreglos en coordenadas x, y con las posiciones dadas en el formulario
$x=[$_GET['1a'],$_GET['2a'],$_GET['3a'],$_GET['4a'],$_GET['5a'],$_GET['6a'],$_GET['7a'],$_GET['8a']];
$y=[$_GET['1b'],$_GET['2b'],$_GET['3b'],$_GET['4b'],$_GET['5b'],$_GET['6b'],$_GET['7b'],$_GET['8b']];
//ciclo que comprueba que no esten lugares repetidos
for($i=0;$i<8;$i++){
    for($j=$i+1;$j<8;$j++){
        if($x[$i]==$x[$j] && $y[$i]==$y[$j]){
            //redireccionar al formulario si es que si hay repetidos
            header('Location:index.html');
        }
    }
}
?>
<style>
    *{
        transition:all 1s;
        box-sizing: border-box;
    }
    body{
        font-family:calibri;
        margin:0;
        padding:0;
        user-select:none;
        background: lightsteelblue;
    }
    #tablero{
        background:slategray;
        
    }
    #tablerobot{
        background:slategray;
        margin-top: 2px;
        margin-left: 2px;
        
    }
    td{
        border: 1px solid black;
        text-align:center;
        font: size 120%;
        color:white;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-image: url(imgs/fondojuego.jpg); background-size: cover; background-repeat: no-repeat;">
    <center><h1>Jugar</h1></center>
    <div style="text-align:center; width:100%;">
        <div style="width:50%; height: 500px; float:left;">
            <b style="font-size:20px;">Tu tablero, <?php echo $nombre; ?></b>   
            <table boder=2 cellspacing=0 cellpadding=0 id="tablero" style="margin:auto; cursor: not-allowed;" ></table>
        </div>
        <div style="width:50%; height: 500px; float:right;">
            <b style="font-size:20px;">Tablero del bot, selecciona una casilla para tirar:</b>
            <table boder=2 cellspacing=0 cellpadding=0 id="tablerobot" style="margin:auto; cursor: crosshair;"></table>
        </div>
        <button style="margin: auto; height:30px; width:200px; border-radius:20px; background-color:aqua; font-size:20px; font-family:sans; display:none;" id="jdn" >Jugar de nuevo</button>
    </div>
    <script>
        //arreglos en x, y del jugador para ocuparlos en script
        let jx=[<?php echo $x[0];?>,<?php echo $x[1];?>,<?php echo $x[2];?>,<?php echo $x[3];?>,<?php echo $x[4];?>,<?php echo $x[5];?>,<?php echo $x[6];?>,<?php echo $x[7];?>]
        let jy=[<?php echo $y[0];?>,<?php echo $y[1];?>,<?php echo $y[2];?>,<?php echo $y[3];?>,<?php echo $y[4];?>,<?php echo $y[5];?>,<?php echo $y[6];?>,<?php echo $y[7];?>]
        //arreglos del bot
        var bx=[]
        var by=[]
        //vriables para filas y columnas para hacer disparos y mostrar visualmente los arreglos
        let filas=10
        let columnas=10
        //total de barcos del bot y del usuario
        let barcosJugador=8
        let barcosBot=8
        //arreglos visibles al usuario
        let tablero=[[],[],[],[],[],[],[],[],[],[]]
        let tableroBot=[[],[],[],[],[],[],[],[],[],[]]
        let ind=0
        //determinar turnos
        var turnoJugador=true
        var turnoBot=true
        //variable para determinar que ninguno ha ganado
        var juegoTerminado=false
        //boton para jugar de nuevo
        let botonp=document.getElementById('jdn')
        botonp.addEventListener('click', function(){
            location.reload()
        })

        nuevoJuego() //funcion para empezar el juego

        function nuevoJuego(){
            //funciones para generar tableros de juego
            tab()
            generarTableroJugador()
            generarTableroBot()
        }

        function tab(){
            for(let i=0;i<10;i++){
                //ciclo que rellena los espacios del tablero con 0
                for(let j=0;j<10;j++){
                    tablero[i][j]=0
                }   
            }
            for(let i=0;i<10;i++){
                //ciclo que rellena los espacios del tablero del bot con 0
                for(let j=0;j<10;j++){
                    tableroBot[i][j]=0
                }   
            }
            do{
                for(let i=0;i<10;i++){
                    for(let j=0;j<10;j++){
                        if(jx[ind] == j && jy[ind] == i){
                            //colocar los barcos del usuario en las posiciones deseadas evaluandolos a 1
                            tablero[i][j]=1;
                            ind++;
                        }
                    }
                }
            }while(ind<8);
        }

        function generarTableroJugador(){
            let html=''
            for(let i=0;i<filas;i++){
                //crear tabla con botones en el documento html de cada casilla
                html+='<tr>'
                for(let j=0;j<columnas;j++){
                    html += '<td><button id="'+i+', '+j+',j" style="width: 40px; height: 40px; background-color: aqua; border: solid 5px aqua; border-radius: 2px; cursor: not-allowed;"></button></td>'
                }
                html+='</tr>'
            }
            let tableroHTML=document.getElementById('tablero')
            tableroHTML.innerHTML=html
            for(i=0;i<8;i++){
                document.getElementById(jy[i]+", "+jx[i]+",j").style.backgroundImage="url(imgs/barco.png)"
                document.getElementById(jy[i]+", "+jx[i]+",j").style.backgroundSize="cover"
            }
        }

        function generarTableroBot(){
            let html=''
            for(let i=0;i<filas;i++){
                //crear tabla con botones en el documento html de cada casilla
                html+='<tr>'
                for(let j=0;j<columnas;j++){
                    html += '<td><button id="'+i+', '+j+',b" style="width: 40px; height: 40px; cursor: pointer; background-color: aqua; border: solid 5px aqua; border-radius: 2px; cursor: crosshair;" onclick="disparo('+i+','+j+')"></button></td>'
                }
                html+='</tr>'
            }
            let tableroHTML=document.getElementById('tablerobot')
            tableroHTML.innerHTML=html
            let numeroBarcosBot=0
            while(numeroBarcosBot<8){
                //colocar los barcos del bot con funcion que obtenga numeros aleatorios del 0 al 9, que es el tamaño del arreglo
                let x = Math.floor(Math.random()*(9-0)+0);
                let y = Math.floor(Math.random()*(9-0)+0);
                if(tableroBot[y][x]!=1){
                    bx[numeroBarcosBot]=x;
                    by[numeroBarcosBot]=y;
                    tableroBot[y][x]=1
                    numeroBarcosBot++
                }
            }
        }

        function disparo(y,x){
            //condicion que dice que se puede seguir jugando si nadie ha ganado
            if(juegoTerminado==false){
                //condicion de que si le da a una casilla con valor 1 es igual a que le dio a un barco
                if(tableroBot[y][x]==1){
                    alert("Has dado a un barco")
                    document.getElementById(y+", "+x+",b").style.backgroundImage="url(imgs/barcodestruido.png)"
                    document.getElementById(y+", "+x+",b").style.backgroundSize="cover"
                    document.getElementById(y+", "+x+",b").style.cursor="not-allowed"
                    //la casilla ahora vale 2 de que ya tiro
                    tableroBot[y][x]=2
                    //si acierta puede tirar de nuevo
                    turnoJugador=true
                    //se disminuye el numero de barcos totales del bot
                    barcosBot--
                    //condicion de que si no le quedan mas barcos al bot, el usuario gana
                    if(barcosBot==0){
                        alert("<?php echo $nombre; ?> ha ganado")
                        juegoTerminado=true
                        //el boton de jugar de nuevo es visible
                        botonp.style.display="block";
                    }
                    //si le da a una casilla con el numero 2 significa que es una casilla a la que ya le dio y puede intentar de nuevo en las disponibles
                }else if(tableroBot[y][x]==2){
                    alert("Ya has dado aqui, intentalo otra vez")
                    console.log("Ya has dado aqui")
                    turnoJugador=true
                    tableroBot[y][x]=2
                    //condicion si le da a una casilla con valor 0 donde no hay nada
                }else if(tableroBot[y][x]==0){
                    document.getElementById(y+", "+x+",b").style.backgroundImage="url(imgs/marea2.png)"
                    document.getElementById(y+", "+x+",b").style.backgroundSize="cover"
                    document.getElementById(y+", "+x+",b").style.cursor="not-allowed"
                    //la casilla ahora vale 2 de que ya tiro
                    tableroBot[y][x]=2
                    console.log("Has dado al mar")
                    turnoJugador=false
                }
                //si el jugador ya tiro y no le dio a nada es turno del bot
                if(turnoJugador==false){
                    turnoBot=true
                    //funcion donde el bot tira
                    disparoBot()
                }
            }
        }

        function disparoBot(){
            //variables utilizadas para coordenadas
            let x
            let y
            //condicion de que si el turno de bot es verdadera va a ejecutar la funcion de tirar
            while(turnoBot==true){
                x = Math.floor(Math.random()*(10-0)+0)
                y = Math.floor(Math.random()*(10-0)+0)
                //si aun no hay ganador tambien se ejecutara la funcion
                if(juegoTerminado==false){
                    //si el bot dispara en el tablero del jugador en una casilla con valor 1 es que si le dio a un barco y podra tirar de nuevo
                    if(tablero[y][x]==1){
                        alert("Bot a dado a un barco")
                        document.getElementById(y+", "+x+",j").style.backgroundImage="url(imgs/barcodestruido.png)"
                        document.getElementById(y+", "+x+",j").style.backgroundSize="cover"
                        //la casilla ahora vale 2 de que ya tiro
                        tablero[y][x]=2
                        turnoBot=true
                        barcosJugador--
                        //si no le quedan barcos al jugador, significa que el bot ha ganado
                        if(barcosJugador==0){
                            alert("El bot ha ganado")
                            document.getElementById(y+", "+x+",j").style.backgroundImage="url(imgs/barcodestruido.png)"
                            document.getElementById(y+", "+x+",j").style.backgroundSize="cover"
                            //los turnos se ponen los dos como falsos para que ya no puedan tirar
                            juegoTerminado=true
                            turnoBot=false;
                            botonp.style.display="block";
                        }
                        //si le da a uno con valor 2 vuelve a tirar porque es una casilla donde ya habia tirado
                    }else if(tablero[y][x]==2){
                        console.log("Bot ha dado aqui")
                        turnoBot=true
                        tablero[y][x]=2
                        //si no le dio a uno repetido ni a un barco entonces le dio a una casilla con valor 0 por lo que ahora es turno del usuario
                    }else{
                        document.getElementById(y+", "+x+",j").style.backgroundImage="url(imgs/marea2.png)"
                        document.getElementById(y+", "+x+",j").style.backgroundSize="cover"
                        tablero[y][x]=2
                        console.log("Bot ha dado al mar")
                        //evaluar a falso la variable del turno del bot para que no pueda tirar y para que ahora tire el usuario
                        turnoBot=false
                    }
                }
            }
        }
    </script>
</body>
</html>
