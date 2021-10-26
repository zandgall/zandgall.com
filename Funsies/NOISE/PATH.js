class PATHS {
    constructor(range) {
        this.array=[];
        for(var i = 0; i<range; i++) {
            this.array[i]=Math.random();
        }
    }
    
    smooth() {
        var pathSkeleton = [];
        for(var i = 0; i<this.array.length; i++) {
            pathSkeleton[i]=this.array[i];
        }
        var index = 0;
        for(var i = 0; i<pathSkeleton.length-1; i++) {
            var a = pathSkeleton[i];
            var b = pathSkeleton[i+1];

            var Qx = a*(3/4)+b*(1/4);

            var Rx = a*(1/4)+b*(3/4);

    //        if((Qx>0&&Qy>0)||(Rx>0&&Ry>0)){
                this.array[index]=Qx;
                index++;
                this.array[index]=Rx;
                index++;
    //        }
        }
        this.array[index]=pathSkeleton[pathSkeleton.length-1];
    }
}

class PATH2D {
    constructor(width, height) {
        this.array=[[]];
        
        for(var x = 0; x<width; x++) {
            this.array[x]=[];
            for(var y = 0; y<height; y++) {
                this.array[x][y]=Math.random();
            }
        }
    }
    
    smooth() {
        var pathSkeleton = [[]];
        for(var x = 0; x<this.array.length; x++) {
            pathSkeleton[x]=[];
            for(var y = 0; y<this.array[x].length; y++) {
                pathSkeleton[x][y]=this.array[x][y];
            }
        }
        
        var inx = 0;
        var iny = 0;
        
        for(var x = 0; x<pathSkeleton.length; x++) {
            
            this.array[x*2]=[];
            this.array[x*2+1]=[];
            
            for(var y = 0; y<pathSkeleton[x].length; y++) {
                
                var r, d;
                
                
                if(x==pathSkeleton.length-1) r=pathSkeleton[0][y];
                else r=pathSkeleton[x+1][y];
                if(y==pathSkeleton[x].length-1) d=pathSkeleton[x][0];
                else d=pathSkeleton[x][y+1];
                
                var t = pathSkeleton[x][y];
                
                var Rx = t*(1/4)+r*(3/4);
                var Ry = t*(1/4)+d*(3/4);
                var Rz = t*(1/4)+r*(3/8)+d*(3/8);
                
                this.array[x*2][y*2]=t;
                this.array[x*2+1][y*2]=Rx;
                this.array[x*2][y*2+1]=Ry;
                this.array[x*2+1][y*2+1]=Rz;
                
            }
        }
    }
}

class VELOCINOISE {
    constructor(frequency, width, height) {
        this.array = [];
        var incrementa = [];
        var increment = 0;
        for(var x = 0; x<width; x++) {
            this.array[x]=[];
            incrementa[x]=[];
            if(x>0)
                increment = incrementa[x-1][0];
            for(var y = 0; y<height; y++) {
                increment+=(Math.random()*2-1)*frequency;
                
                if(x!=0 && y!=0) {
                    increment=increment*(2/3)+(incrementa[x-1][y]+incrementa[x][y-1])/3;
                }
                incrementa[x][y]=increment;
                this.array[x][y]=increment;
            }
        }
    }
}

class SINENOISE {
    constructor(frequency, width, height) {
        this.array = [];
        var incrementa = [];
        var increment = 0;
        for(var x = 0; x<width; x++) {
            this.array[x]=[];
            incrementa[x]=[];
            increment=Math.sin(x);
            for(var y = 0; y<height; y++) {
                increment+=(Math.random()*2-1)*frequency;
                
                if(x!=0 && y!=0) {
                    increment=increment*(2/3)+(incrementa[x-1][y]+incrementa[x][y-1])/3;
                }
                incrementa[x][y]=increment;
                this.array[x][y]=increment;
            }
        }
    }
}






var B = 0x100;
var BM = 0xff;

var N = 0x1000;
var NP = 12;   /* 2^N */
var NM = 0xfff;

var p = [];
var g1 = [];
var g2 = [[]];
var g3 = [[[]]];

var start = 1;

function s_curve(t) { 
    return t * t * (3.0 - 2.0 * t);
}

function lerp(t, a, b) {
    return a + t * (b - a);
}

function setup(vec, i) {
    var t = vec[i] + N;
	var b0 = (Math.floor(t)) & BM;
	var b1 = (b0+1) & BM;
	var r0 = t - Math.floor(t);
	var r1 = r0 - 1.0;
    
    return [t, b0, b1, r0, r1];
}

function setup(i) {
    var t = i + N;
	var b0 = (Math.floor(t)) & BM;
	var b1 = (b0+1) & BM;
	var r0 = t - Math.floor(t);
	var r1 = r0 - 1.0;
    
    return [t, b0, b1, r0, r1];
}

function noise1(arg) {
    var bx0, bx1;
	var rx0, rx1, sx, t, u, v, vec = [];

	vec[0] = arg;
	if (start==1) {
		start = 0;
		PERLININIT();
	}
    
    var s = setup(vec, 0);
    
	bx0 = s[1];
	bx1 = s[2];
	rx0 = s[3];
	rx1 = s[4];
    
	sx = s_curve(rx0);

	u = rx0 * g1[ p[ bx0 ] ];
	v = rx1 * g1[ p[ bx1 ] ];
    
	return lerp(sx, u, v);
}

function noise2(x, y) {
    var bx0, bx1, by0, by1, b00, b10, b01, b11;
	var rx0, rx1, ry0, ry1, q, sx, sy, a, b, t, u, v;
	var i, j;

	if (start==1) {
		start = 0;
		PERLININIT();
	}

	var s1 = setup(x);
    
    bx0 = s1[1];
	bx1 = s1[2];
	rx0 = s1[3];
	rx1 = s1[4];
    
	var s2 = setup(y);

    by0 = s2[1];
	by1 = s2[2];
	ry0 = s2[3];
	ry1 = s2[4];
    
	i = p[ bx0 ];
	j = p[ bx1 ];

	b00 = p[ i + by0 ];
	b10 = p[ j + by0 ];
	b01 = p[ i + by1 ];
	b11 = p[ j + by1 ];

	sx = s_curve(rx0);
	sy = s_curve(ry0);

	q = g2[ b00 ] ; 
    u = rx0 * q[0] + ry0 * q[1];
	q = g2[ b10 ] ; 
    v = rx1 * q[0] + ry0 * q[1];
	a = lerp(sx, u, v);
    
	q = g2[ b01 ] ; 
    u = rx0 * q[0] + ry1 * q[1];
	q = g2[ b11 ] ; 
    v = rx1 * q[0] + ry1 * q[1];
	b = lerp(sx, u, v);
    
	return lerp(sy, a, b);
}

function noise3(x, y, z) {
    var bx0, bx1, by0, by1, bz0, bz1, b00, b10, b01, b11;
	var rx0, rx1, ry0, ry1, rz0, rz1, q, sy, sz, a, b, c, d, t, u, v;
	var i, j;

	if (start==1) {
		start = 0;
		PERLININIT();
	}

	var s1 = setup(x);
    
    bx0 = s1[1];
	bx1 = s1[2];
	rx0 = s1[3];
	rx1 = s1[4];
    
	var s2 = setup(y);

    by0 = s2[1];
	by1 = s2[2];
	ry0 = s2[3];
	ry1 = s2[4];
	
    var s3 = setup(z);

    bz0 = s3[1];
	bz1 = s3[2];
	rz0 = s3[3];
	rz1 = s3[4];

	i = p[ bx0 ];
	j = p[ bx1 ];

	b00 = p[ i + by0 ];
	b10 = p[ j + by0 ];
	b01 = p[ i + by1 ];
	b11 = p[ j + by1 ];

	t  = s_curve(rx0);
	sy = s_curve(ry0);
	sz = s_curve(rz0);

//#define at3(rx,ry,rz) ( rx * q[0] + ry * q[1] + rz * q[2] )

	q = g3[ b00 + bz0 ] ; 
    u = ( rx0 * q[0] + ry0 * q[1] + rz0 * q[2] );
	q = g3[ b10 + bz0 ] ; 
    v = ( rx1 * q[0] + ry0 * q[1] + rz0 * q[2] );
	a = lerp(t, u, v);

	q = g3[ b01 + bz0 ] ; 
    u = ( rx0 * q[0] + ry1 * q[1] + rz0 * q[2] );;
	q = g3[ b11 + bz0 ] ; 
    v = ( rx1 * q[0] + ry1 * q[1] + rz0 * q[2] );;
	b = lerp(t, u, v);

	c = lerp(sy, a, b);

	q = g3[ b00 + bz1 ] ; 
    u = ( rx0 * q[0] + ry0 * q[1] + rz1 * q[2] );;
	q = g3[ b10 + bz1 ] ; 
    v = ( rx1 * q[0] + ry0 * q[1] + rz1 * q[2] );;
	a = lerp(t, u, v);

	q = g3[ b01 + bz1 ] ; 
    u = ( rx0 * q[0] + ry1 * q[1] + rz1 * q[2] );;
	q = g3[ b11 + bz1 ] ; 
    v = ( rx1 * q[0] + ry1 * q[1] + rz1 * q[2] );;
	b = lerp(t, u, v);

	d = lerp(sy, a, b);

	return lerp(sz, c, d);
}

function normalize2(v) {
	var s;

	s = Math.sqrt(v[0] * v[0] + v[1] * v[1]);
	v[0] = v[0] / s;
	v[1] = v[1] / s;
    return v;
}

function normalize3(v) {
	var s;

	s = Math.sqrt(v[0] * v[0] + v[1] * v[1] + v[2] * v[2]);
	v[0] = v[0] / s;
	v[1] = v[1] / s;
    v[2] = v[2] / s;
    return v;
}

function PERLININIT() {
    var i, j, k;
    
    for (i = 0 ; i < B ; i++) {
		p[i] = i;

		g1[i] = ((Math.random() *(B + B)) - B) / B;
        
        g2[i] = [];
        for (j = 0 ; j < 2 ; j++)
			g2[i][j] = ((Math.random() *(B + B)) - B) / B;
		g2[i] = normalize2(g2[i]);
        
        g3[i] = [];
        for (j = 0 ; j < 3 ; j++)
			g3[i][j] = ((Math.random() *(B + B)) - B) / B;
		g3[i] = normalize3(g3[i]);
    }
    
    while(i>0) {
        i--;
        k = p[i];
        j = Math.random() * B;
		p[i] = p[Math.floor(j)];
		p[Math.floor(j)] = k;
    }
    for (i = 0 ; i < B + 2 ; i++) {
		p[B + i] = p[i];
		g1[B + i] = g1[i];
        if(g2[B + i]==null)
            g2[B + i]=[];
        for (j = 0 ; j < 2 ; j++)
			g2[B + i][j] = g2[i][j];
        
        if(g3[B + i]==null)
            g3[B + i]=[];
        for (j = 0 ; j < 3 ; j++)
			g3[B + i][j] = g3[i][j];
    }
}

