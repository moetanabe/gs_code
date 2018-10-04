    // canvas base
 const can = $("#canvas")[0];
 const ctx = can.getContext("2d");

 /*---------------------------
  * ufoについて
  *--------------------------*/
  //ufoのオブジェクトデータ
 const ufo = {
     posX:0,
     posY:can.height/2,
     flag:false,
     img:"images/pizzashop.png",
 };

 //ufo描画のための関数
 const ufoDraw=function(){
     const newImage = $("<img>").attr("src",ufo.img);
     newImage.on("load",function(){
         ctx.drawImage(this, ufo.posX, ufo.posY);
         ufo.img = this;
         ufo.width=this.width;
         ufo.height=this.height;
     });  
 }


 // マウス動いたらufoを動かす関数
 const ufoMove=function(e){
     ufo.flag = true;
     if(ufo.flag){
         ctx.clearRect(0, ufo.posY, ufo.width, ufo.height);
         ufo.posY = e.offsetY - ufo.height/2; //ufoの位置情報更新Y
         ctx.drawImage(ufo.img, 0, ufo.posY);
     }
 };


 // マウスアウトしたらUFOの動き止める
 const ufoStop = function(){
     ufo.flag = false;
 }

 /*---------------------------
  * 敵について
  *--------------------------*/
 const enemy = {
     posX:can.width - 82,
     posY:can.height/2,
     src:"images/stamp10.png",//画像のURL 
     img:""// img タグ
 }
 
 //敵をえがく
 const enemyDraw = function(e){
     console.log(e);
     const newImage = $("<img>").attr("src",enemy.src);
     newImage.on("load",function(){
         enemy.img = this;
         enemy.width=this.width;
         enemy.height=this.height;
         const randomNum = Math.ceil(Math.random()*can.height);
         console.log(randomNum,enemy.img);
         enemy.posY = randomNum;
    
         ctx.drawImage(this, enemy.posX, randomNum);
     }); 
 };

 /*---------------------------
  * ufoが発射する弾について
  *--------------------------*/
  //弾のオブジェクト元データ
  const ballData = {
     speed:5,
     width:10,
     height:10,
     posX:0,
     posY:0,
     color:"#d00",
     
 }

 //発射された弾を格納するための配列を作成
 const ballGroup = [];

 // 新しい弾を発射する関数
 const shootBall = function(e){
     const newShootBall = Object.assign({},ballData);
     newShootBall.posX = ufo.width;
     newShootBall.posY = ufo.posY + (ufo.height/2 - newShootBall.height/2);
     ctx.fillStyle = newShootBall.color;
     ctx.fillRect(newShootBall.posX, newShootBall.posY, newShootBall.width, newShootBall.height);
     ballGroup.push(newShootBall);
 }
 
 // 配列内の全ての弾の位置を移動させる
 const moveBall=function(){
     for(let i=0;i<ballGroup.length;i++){               
         const ball =ballGroup[i];
         ctx.clearRect(ball.posX, ball.posY, ball.width, ball.height);
         ctx.fillStyle = ball.color;
         ball.posX += ball.speed;
         ctx.fillRect(ball.posX, ball.posY, ball.width, ball.height);           
     }
 };

 // 配列内の全てのボールを精査して、canvasからスクリーンアウトしたら
 // 配列から該当の弾のデータを消去
 const deleteBall=function(){
     for(let i = 0; i < ballGroup.length; i++) {
         if (ballGroup[i].posX >= can.width) {
             ballGroup.splice(i,1);
         }
     }
 };
 
 /*---------------------------
  * 当たり判定
  *--------------------------*/
 const hitJudge = function(e){
     for(let k=0;k<ballGroup.length;k++){

         const ballLeft = ballGroup[k].posX;
         const ballRight = ballLeft + ballGroup[k].width;
         const ballTop = ballGroup[k].posY;
         const ballBottom = ballTop + ballGroup[k].height;

         const enemyLeft = enemy.posX;
         const enemyTop = enemy.posY;
         const enemyBottom = enemyTop + enemy.height;

         if((ballRight >= enemyLeft) &&
            (ballTop <= enemyBottom) && 
            (ballBottom >= enemyTop)
           ){                              
             ctx.clearRect(ballLeft, ballTop, ballGroup[k].width, ballGroup[k].height);
             ctx.clearRect(enemyLeft, enemyTop, enemy.width, enemy.height);
             ballGroup.splice(k,1);  
             console.log("あたった");
             const customEvent = "hit";
             enemyDraw(customEvent);
         }
     }  
 };

 


 /*---------------------------
  * ページ読み込み時の描画処理
  *--------------------------*/
 $(window).on("load",function(){
     ufoDraw();
     enemyDraw();
     hitJudge();
 });


 /*---------------------------
  * ゲームスタートしてからのループ処理
  *--------------------------*/
 setInterval(function(){
     moveBall();
     deleteBall();
     hitJudge();
 },10);

 //UFOに位置移動に関するイベント追加
 $(can).on("mousemove",ufoMove);
 $(can).on("mouseout",ufoStop);

 //クリックしたら弾発射
 $(can).on("mousedown",shootBall);



//新しい敵を格納するための配列を作成
 const enemyGroup = [];

// 新しい敵を出す関数
 const addenemy = function(e){
     const newEnemy = Object.assign({},enemyData);
     newEnemy.posX = enemy.width;
     newEnemy.posY = enemy.posY + (enemy.height/2 - newEnemy.height/2);
     ctx.fillStyle = newEnemy.color;
     ctx.fillRect(newEnemy.posX, newEnemy.posY, newEnemy.width, newEnemy.height);
     enemyGroup.push(newEnemy);
 }
