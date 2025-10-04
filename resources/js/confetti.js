(function () {
    class Vector {
        constructor(x = 0, y = 0) {
            this.x = x;
            this.y = y;
        }
    }

    class Particle {
        constructor(position) {
            this.size = new Vector((16 * Math.random() + 4), (4 * Math.random() + 4));
            this.position = new Vector(position.x - this.size.x / 2, position.y - this.size.y / 2);
            this.velocity = ConfettiHelper.generateVelocity();
            this.rotation = 360 * Math.random();
            this.rotation_speed = 10 * (Math.random() - 0.5);
            this.hue = 360 * Math.random();
            this.opacity = 100;
            this.lifetime = Math.random() + 0.25;
        }

        update(dt) {
            this.velocity.y += 10 * (this.size.y / 10) * dt;
            this.velocity.x += 25 * (Math.random() - 0.5) * dt;
            this.velocity.y *= 0.98;
            this.velocity.x *= 0.98;
            this.position.x += this.velocity.x;
            this.position.y += this.velocity.y;
            this.rotation += this.rotation_speed;
            this.opacity -= this.lifetime;
        }

        checkBounds() {
            return this.position.y - 2 * this.size.x > 2 * window.innerHeight;
        }

        draw() {
            if (ConfettiRenderer.CTX) {
                const ctx = ConfettiRenderer.CTX;
                ctx.save();
                ctx.beginPath();
                ctx.translate(this.position.x + this.size.x / 2, this.position.y + this.size.y / 2);
                ctx.rotate(this.rotation * Math.PI / 180);
                ctx.rect(-this.size.x / 2, -this.size.y / 2, this.size.x, this.size.y);
                ctx.fillStyle = `hsla(${this.hue}deg, 90%, 65%, ${this.opacity}%)`;
                ctx.fill();
                ctx.restore();
            }
        }
    }

    class Burst {
        constructor(position) {
            this.particles = [];
            for (let i = 0; i < 100; i++) {
                this.particles.push(new Particle(position));
            }
        }

        update(dt) {
            for (let i = this.particles.length - 1; i >= 0; i--) {
                this.particles[i].update(dt);
                if (this.particles[i].checkBounds()) {
                    this.particles.splice(i, 1);
                }
            }
        }

        draw() {
            for (let p of this.particles) {
                p.draw();
            }
        }
    }

    class ConfettiHelper {
        static generateVelocity() {
            let x = Math.random() - 0.5;
            let y = Math.random() - 0.7;
            const len = Math.sqrt(x * x + y * y);
            x /= len;
            y /= len;
            return new Vector(x * (Math.random() * 15), y * (Math.random() * 15));
        }
    }

    class ConfettiRenderer {
        static setupCanvas() {
            if (!ConfettiRenderer.CTX) {
                const canvas = document.createElement('canvas');
                ConfettiRenderer.CTX = canvas.getContext('2d');
                canvas.width = 2 * window.innerWidth;
                canvas.height = 2 * window.innerHeight;
                canvas.style.position = 'fixed';
                canvas.style.top = '0';
                canvas.style.left = '0';
                canvas.style.width = '100%';
                canvas.style.height = '100%';
                canvas.style.zIndex = '999999999';
                canvas.style.pointerEvents = 'none';
                document.body.appendChild(canvas);
                window.addEventListener('resize', () => {
                    canvas.width = 2 * window.innerWidth;
                    canvas.height = 2 * window.innerHeight;
                });
            }
        }

        static clear() {
            if (ConfettiRenderer.CTX) {
                ConfettiRenderer.CTX.clearRect(0, 0, 2 * window.innerWidth, 2 * window.innerHeight);
            }
        }
    }

    class FixedConfetti {
        constructor() {
            this.bursts = [];
            this.time = Date.now();
            this.deltaTime = 0;

            ConfettiRenderer.setupCanvas();

            const btn = document.getElementById('subscribe');
            if (btn) {
                btn.addEventListener('click', (e) => {
                    if (btn.innerText.trim().toLowerCase() === 'subscribe') {
                        const position = new Vector(2 * e.clientX, 2 * e.clientY);
                        this.bursts.push(new Burst(position));
                    }
                });
            }

            requestAnimationFrame(this.update.bind(this));
        }

        update(currentTime) {
            this.deltaTime = (currentTime - this.time) / 1000;
            this.time = currentTime;

            for (let i = this.bursts.length - 1; i >= 0; i--) {
                this.bursts[i].update(this.deltaTime);
                if (this.bursts[i].particles.length === 0) {
                    this.bursts.splice(i, 1);
                }
            }

            ConfettiRenderer.clear();
            for (let burst of this.bursts) {
                burst.draw();
            }

            requestAnimationFrame(this.update.bind(this));
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        new FixedConfetti();
    });
})();
