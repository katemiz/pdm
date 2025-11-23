



function DrawArticle(ctx,x,y,has_circle = false, has_text = false) {

    let dist = 50

    ctx.beginPath();

        ctx.strokeStyle = "black"
        ctx.lineWidth = 0.1;

        ctx.moveTo(x-dist, y);
        ctx.lineTo(x+dist, y);

        ctx.moveTo(x, y-dist);
        ctx.lineTo(x, y+dist);

    ctx.stroke();

    if (has_circle) {
        ctx.beginPath();
            ctx.arc(x, y, 5, 0, 2 * Math.PI);
            ctx.fillStyle = "red";
            ctx.fill();
        ctx.stroke();
    }






}



function DrawArrow(ctx,x,y,angle,text=false) {

    let dist = 5

    ctx.save()
    ctx.translate(x, y);
    ctx.rotate(angle* Math.PI / 180);// angle must be in radians

    ctx.beginPath();

        ctx.strokeStyle = "black"
        ctx.lineWidth = 0.1;

        ctx.moveTo(0, 0);
        ctx.lineTo(0, -dist);
        ctx.lineTo(3*dist, 0);
        ctx.lineTo(0, dist);

        ctx.fillStyle = "blue";
        ctx.fill();

        if (text) {
            ctx.fillText(text,0,-20);
        }

    ctx.stroke();
    ctx.restore()
}
