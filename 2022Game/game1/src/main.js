var ENGINE = {
    config: {
        baseWidth: 480,
        baseHeight: 720
    },
    initGame: function () {
        this.game = new Phaser.Game(this.config.baseWidth, this.config.baseHeight, Phaser.AUTO);

        this.game.state.add('BootState', this.state.boot);
        this.game.state.add('PreloadState', this.state.preload);
        this.game.state.add('MenuState', this.state.menu);
        this.game.state.add('GameState', this.state.game);
        this.game.state.add('OverState', this.state.over);

        this.game.state.start('BootState');
    },
    pauseGame: function () {
        this.game.sound.mute = true;
        this.game.paused = true;
    },
    resumeGame: function () {
        this.game.paused = false;
        this.game.sound.mute = ENGINE.audioManager.mute;
    },
    state: {},
    localStorage: {
        key: 'seapartyscore',
        isSupported: false,
        test: function () {
            if (typeof localStorage !== 'object') {
                return false;
            }

            try {
                localStorage.setItem('localStorage', 1);
                localStorage.removeItem('localStorage');
            } catch (e) {
                return false;
            }

            this.isSupported = true;
        },
        encode: function (val) {
            return btoa(JSON.stringify(val));
        },
        decode: function (str) {
            return JSON.parse(atob(str));
        },
        set: function (val) {
            if (this.isSupported) {
                localStorage.setItem(this.key, this.encode(val));
            }
        },
        get: function () {
            if (this.isSupported && this.has()) {
                return this.decode(localStorage.getItem(this.key));
            }

            return 0;
        },
        has: function () {
            if (this.isSupported) {
                return localStorage.getItem(this.key) !== null;
            }

            return false;
        }
    },
    audioManager: {
        mute: false,
        soundEffects: {},
        init: function (game) {
            this.soundEffects['fade'] = game.add.audio('fade', 0.2);
            this.soundEffects['click'] = game.add.audio('click', 0.75);
            this.soundEffects['select'] = game.add.audio('select', 0.25);
            this.soundEffects['swap'] = game.add.audio('swap', 0.75);
            this.soundEffects['pop'] = game.add.audio('pop', 0.5);
            this.soundEffects['counting'] = game.add.audio('counting', 1);
            this.soundEffects['highscore'] = game.add.audio('highscore', 1);

            this.soundEffects['click'].allowMultiple = true;
            this.soundEffects['select'].allowMultiple = true;
            this.soundEffects['swap'].allowMultiple = true;
            this.soundEffects['pop'].allowMultiple = true;

            this.musicLoop = game.add.audio('music', 0.2, true);
            this.musicLoop.play();
        },
        switch: function (button) {
            if (ENGINE.audioManager.mute) {
                ENGINE.audioManager.mute = false;
                ENGINE.game.sound.mute = false;

                button.setFrames('soundBtn/0', 'soundBtn/0', 'soundBtn/1', 'soundBtn/0');

                ENGINE.audioManager.play('click');
            } else {
                ENGINE.audioManager.mute = true;
                ENGINE.game.sound.mute = true;

                button.setFrames('soundBtn/2', 'soundBtn/2', 'soundBtn/3', 'soundBtn/2');
            }
        },
        play: function (sound) {
            if (!this.mute && this.soundEffects[sound]) {
                this.soundEffects[sound].play();
            }
        }
    },
    adManager: {
        addListener: function () {
            ENGINE.game.input.onDown.add(this.showAdd, this);
        },
        removeListener: function () {
            ENGINE.game.input.onDown.remove(this.showAdd, this);
        },
        showAdd: function () {
            try {
                gdsdk.showBanner();
            } catch (err) {
                console.log('>> GD Api blocked by AdBlocker.')
            }

            ENGINE.adManager.removeListener();
        }
    }
};


window["GD_OPTIONS"] = {
    "gameId": "4727abe9326c4c9c84563b474dfeeec0",
    "onEvent": function (event) {
        switch (event.name) {
            case "SDK_READY":
                // skd loaded, init game here
                break;
            case "SDK_GAME_START":
                ENGINE.resumeGame();
                break;
            case "SDK_GAME_PAUSE":
                ENGINE.pauseGame();
                break;
        }
    },
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://html5.api.gamedistribution.com/main.min.js';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'gamedistribution-jssdk'));


WebFont.load({
    active: function () {
        ENGINE.initGame();
    },
    google: {
        families: ['Pacifico']
    }
});


ENGINE.state.boot = function () { };
ENGINE.state.boot.prototype = {
    preload: function () {
        this.stage.backgroundColor = 0x249e9d;

        this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;

        this.scale.pageAlignHorizontally = true;
        this.scale.pageAlignVertically = true;

        this.load.image('loadingText', 'assets/loadingText.png');
        this.load.image('loadingBarBg', 'assets/loadingBarBg.png');
        this.load.image('loadingBar', 'assets/loadingBar.png');
    },
    create: function () {
        this.state.start('PreloadState');
    }
};


ENGINE.state.preload = function () { };
ENGINE.state.preload.prototype = {
    preload: function () {
        this.loadingText = this.add.sprite(this.game.width * 0.5, this.game.height * 0.5 - 50, 'loadingText');
        this.loadingText.anchor.setTo(0.5);

        this.loadingBarBg = this.add.sprite(90, this.game.height * 0.5 + 0, 'loadingBarBg');
        this.loadingBar = this.add.sprite(90, this.game.height * 0.5 + 0, 'loadingBar');

        this.load.setPreloadSprite(this.loadingBar);

        this.load.atlasJSONHash('atlas', 'assets/atlas.png', 'assets/atlas.json');

        this.load.audio('counting', ['assets/soundeffects/counting.ogg', 'assets/soundeffects/counting.m4a', 'assets/soundeffects/counting.mp3']);
        this.load.audio('fade', ['assets/soundeffects/fade.ogg', 'assets/soundeffects/fade.m4a', 'assets/soundeffects/fade.mp3']);
        this.load.audio('highscore', ['assets/soundeffects/highscore.ogg', 'assets/soundeffects/highscore.m4a', 'assets/soundeffects/highscore.mp3']);
        this.load.audio('pop', ['assets/soundeffects/pop.ogg', 'assets/soundeffects/pop.m4a', 'assets/soundeffects/pop.mp3']);
        this.load.audio('click', ['assets/soundeffects/click.ogg', 'assets/soundeffects/click.m4a', 'assets/soundeffects/click.mp3']);
        this.load.audio('select', ['assets/soundeffects/select.ogg', 'assets/soundeffects/select.m4a', 'assets/soundeffects/select.mp3']);
        this.load.audio('swap', ['assets/soundeffects/swap.ogg', 'assets/soundeffects/swap.m4a', 'assets/soundeffects/swap.mp3']);

        this.load.audio('music', ['assets/music/music.ogg', 'assets/music/music.m4a', 'assets/music/music.mp3']);
    },
    create: function () {
        ENGINE.localStorage.test();
        ENGINE.audioManager.init(this.game);

        this.animateOut();
    },
    animateOut: function () {
        ENGINE.audioManager.play('fade');

        this.game.camera.fade(0x249e9d, 500);

        this.time.events.add(700, function () {
            this.state.start('MenuState');
        }, this);
    }
};


ENGINE.state.menu = function () { };
ENGINE.state.menu.prototype = {
    create: function () {
        ENGINE.adManager.addListener();

        this.background = this.add.sprite(0, 0, 'atlas', 'background');

        this.emitter = this.add.emitter(this.game.width * 0.5, this.game.height * 0.5 + 320, 16);
        this.emitter.makeParticles('atlas', 'particleBig');
        this.emitter.setScale(0, 1, 0, 1, 14000, Phaser.Easing.Linear.None)
        this.emitter.setAlpha(0, 0.15, 8000, Phaser.Easing.Linear.None, true);
        this.emitter.minParticleSpeed.setTo(-20, -20);
        this.emitter.maxParticleSpeed.setTo(20, 0);
        this.emitter.setRotation(-20, 20);
        this.emitter.gravity = -20;
        this.emitter.width = 400;
        this.emitter.flow(8000, 500, 1, -1, true);

        this.lights = this.add.sprite(this.game.width * 0.5, -50, 'atlas', 'lights');
        this.lights.anchor.setTo(0.5, 0);
        this.lights.angle = -5;

        this.title = this.add.sprite(this.game.width * 0.5, this.game.height * 0.5 - 200, 'atlas', 'logo');
        this.title.anchor.setTo(0.5);
        this.title.angle = -2;

        this.playBtn = this.add.button(this.game.width * 0.5, this.game.height * 0.5, 'atlas', this.startGame, this, 'playBtn/0', 'playBtn/0', 'playBtn/1', 'playBtn/0');
        this.playBtn.anchor.setTo(0.5);

        this.soundBtn = this.add.button(this.game.width * 0.5, this.game.height * 0.5 + 200, 'atlas', ENGINE.audioManager.switch, this, 'soundBtn/0', 'soundBtn/0', 'soundBtn/1', 'soundBtn/0');
        this.soundBtn.anchor.setTo(0.5);

        this.animateIn();
    },
    startGame: function () {
        ENGINE.audioManager.play('click');

        this.disableInput();
        this.animateOut();
    },
    disableInput: function () {
        this.playBtn.input.enabled = false;
        this.soundBtn.input.enabled = false;
    },
    enableInput: function () {
        this.playBtn.input.enabled = true;
        this.soundBtn.input.enabled = true;
    },
    animateIn: function () {
        this.disableInput();

        this.add.tween(this.background).from({ alpha: 0 }, 2000, Phaser.Easing.Linear.None, true);

        this.add.tween(this.lights).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 1000);
        this.add.tween(this.lights).to({ angle: 5 }, 4000, Phaser.Easing.Linear.None, true, 0, -1, true);
        this.add.tween(this.lights).to({ y: -200 }, 3000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.add.tween(this.title).from({ y: 0 }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.title).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.title.scale).to({ x: 1.2, y: 1.1 }, 4000, Phaser.Easing.Linear.None, true, 0, -1, true);
        this.add.tween(this.title).to({ angle: 2 }, 3000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.add.tween(this.playBtn).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.playBtn.scale).to({ x: 1.1, y: 1.1 }, 1000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.add.tween(this.soundBtn).from({ y: this.game.height }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.soundBtn).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.soundBtn.scale).to({ x: 1.15, y: 1.1 }, 2000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.time.events.add(1500, this.enableInput, this);
    },
    animateOut: function () {
        ENGINE.audioManager.play('fade');

        this.game.camera.fade(0x249e9d, 500);

        this.time.events.add(700, function () {
            this.state.start('GameState')
        }, this);
    }
};


ENGINE.state.game = function () { };
ENGINE.state.game.prototype = {
    create: function () {
        this.initUI();
        this.initGame();
    },
    initUI: function () {
        this.background = this.add.sprite(0, 0, 'atlas', 'background');

        this.emitter = this.add.emitter(this.game.width * 0.5, this.game.height * 0.5 + 320, 16);
        this.emitter.makeParticles('atlas', 'particleBig');
        this.emitter.setScale(0, 1, 0, 1, 14000, Phaser.Easing.Linear.None)
        this.emitter.setAlpha(0, 0.15, 8000, Phaser.Easing.Linear.None, true);
        this.emitter.minParticleSpeed.setTo(-20, -20);
        this.emitter.maxParticleSpeed.setTo(20, 0);
        this.emitter.setRotation(-20, 20);
        this.emitter.gravity = -20;
        this.emitter.width = 400;
        this.emitter.flow(8000, 500, 1, -1, true);

        this.lights = this.add.sprite(this.game.width * 0.5, -50, 'atlas', 'lights');
        this.lights.anchor.setTo(0.5, 0);
        this.lights.angle = -5;

        this.gameGrid = this.add.sprite(28, 114, 'atlas', 'grid');

        this.tilesGroup = this.add.group();

        this.gameBar = this.add.sprite(0, 0, 'atlas', 'gameBar');

        this.scoreIcon = this.add.sprite(60, 40, 'atlas', 'scoreSmall');
        this.scoreIcon.anchor.setTo(0.5);

        this.scoreText = this.add.text(104, -12, '0', { font: '48pt Pacifico', fill: '#ffffff' });
        this.scoreText.setShadow(2, 2, 'rgba(23, 108, 121, 1)', 0);

        this.pauseBtn = this.add.button(400, 19, 'atlas', this.pauseGame, this, 'pauseBtn', 'pauseBtn', 'pauseBtn', 'pauseBtn');

        this.timeBarBg = this.add.tileSprite(0, 80, this.game.width, 6, 'atlas', 'timeBarBg');
        this.timeBar = this.add.tileSprite(0, 80, this.game.width, 6, 'atlas', 'timeBar');

        this.particleGroup = this.add.group();

        this.particleArray = [];
        for (var x = 0; x < 6; x++) {
            this.particleArray[x] = [];
            for (var y = 0; y < 7; y++) {
                this.particleArray[x][y] = this.add.emitter(60 + x * 72, 146 + y * 72, 4);
                this.particleArray[x][y].makeParticles('atlas', 'particleSmall');
                this.particleArray[x][y].gravity = 0;
                this.particleArray[x][y].setRotation(-360, 360);
                this.particleArray[x][y].setScale(0, 1, 0, 1, 500, Phaser.Easing.Linear.None)
                this.particleArray[x][y].setAlpha(1, 0, 1000, Phaser.Easing.Linear.None, true);
                this.particleArray[x][y].setXSpeed(-50, 50);
                this.particleArray[x][y].setYSpeed(-50, 50);
                this.particleGroup.add(this.particleArray[x][y]);
            }
        }

        this.pauseGroup = this.add.group();

        this.pauseBackground = this.add.tileSprite(0, 0, this.game.width, this.game.height, 'atlas', 'timeBarBg');
        this.pauseBackground.alpha = 0.75;
        this.pauseGroup.add(this.pauseBackground);

        this.playBtn = this.add.button(this.game.width * 0.5, this.game.height * 0.5 - 70, 'atlas', this.resumeGame, this, 'playBtn/0', 'playBtn/0', 'playBtn/1', 'playBtn/0');
        this.playBtn.anchor.setTo(0.5);
        this.playBtn.input.enabled = false;
        this.pauseGroup.add(this.playBtn);

        this.soundBtn = this.add.button(this.game.width * 0.5, this.game.height * 0.5 + 110, 'atlas', ENGINE.audioManager.switch, this, 'soundBtn/0', 'soundBtn/0', 'soundBtn/1', 'soundBtn/0');
        this.soundBtn.anchor.setTo(0.5);
        this.soundBtn.input.enabled = false;
        (this.sound.mute) ? this.soundBtn.setFrames('soundBtn/2', 'soundBtn/2', 'soundBtn/3', 'soundBtn/2') : this.soundBtn.setFrames('soundBtn/0', 'soundBtn/0', 'soundBtn/1', 'soundBtn/0');
        this.pauseGroup.add(this.soundBtn);

        this.pauseGroup.visible = false;

        this.animateIn();
    },
    animateIn: function () {
        this.add.tween(this.background).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true);

        this.add.tween(this.lights).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 1000);
        this.add.tween(this.lights).to({ angle: 5 }, 4000, Phaser.Easing.Linear.None, true, 0, -1, true);
        this.add.tween(this.lights).to({ y: -200 }, 3000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.add.tween(this.gameBar).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.scoreIcon).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.scoreText).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.pauseBtn).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.timeBarBg).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.timeBar).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);

        this.add.tween(this.gameGrid).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.tilesGroup).from({ alpha: 0 }, 500, Phaser.Easing.Linear.None, true, 500);
    },
    pauseGame: function () {
        ENGINE.audioManager.play('click');
        ENGINE.audioManager.play('fade');

        this.pauseBtn.input.enabled = false;

        this.gamePaused = true;

        this.pauseGroup.visible = true;

        this.pauseBackground.alpha = 0.75;
        this.add.tween(this.pauseBackground).from({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);

        this.playBtn.alpha = 1;
        this.playBtn.input.useHandCursor = true;
        this.add.tween(this.playBtn).from({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);

        this.soundBtn.alpha = 1;
        this.soundBtn.input.useHandCursor = true;
        this.add.tween(this.soundBtn).from({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);

        this.time.events.add(200, function () {
            this.playBtn.input.enabled = true;
            this.soundBtn.input.enabled = true;
        }, this);
    },
    resumeGame: function () {
        ENGINE.audioManager.play('click');
        ENGINE.audioManager.play('fade');

        this.playBtn.input.enabled = false;
        this.soundBtn.input.enabled = false;

        this.gamePaused = false;

        this.add.tween(this.pauseBackground).to({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);
        this.add.tween(this.playBtn).to({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);
        this.add.tween(this.soundBtn).to({ alpha: 0 }, 200, Phaser.Easing.Linear.None, true);

        this.time.events.add(200, function () {
            this.pauseGroup.visible = false;
            this.pauseBtn.input.enabled = true;
        }, this);
    },
    initGame: function () {
        this.gameOver = false;
        this.gamePaused = false;

        this.canPick = true;
        this.selectedTile = null;

        this.currentScore = 0;

        this.roundTime = 90;
        this.currentTime = this.roundTime;

        this.hintTimer = 0;
        this.hintArray = [];
        this.hintTween = null;
        this.currentHint = null;

        this.tilesArray = [
            this.rnd.integerInRange(0, 2),
            this.rnd.integerInRange(3, 5),
            this.rnd.integerInRange(6, 8),
            this.rnd.integerInRange(9, 11)
        ];

        this.gameArray = [];
        for (var x = 0; x < 6; x++) {
            this.gameArray[x] = [];
            for (var y = 0; y < 7; y++) {
                this.gameArray[x][y] = {};

                this.gameArray[x][y].pos = { x: x, y: y };

                this.gameArray[x][y].sprite = this.add.sprite(60 + x * 72, 146 + y * 72, 'atlas');
                this.gameArray[x][y].sprite.anchor.setTo(0.5);
                this.gameArray[x][y].sprite.alpha = 1;
                this.tilesGroup.add(this.gameArray[x][y].sprite);

                do {
                    var color = this.rnd.integerInRange(0, 3);
                    this.gameArray[x][y].color = color;
                    this.gameArray[x][y].sprite.frameName = 'tile/' + this.tilesArray[color];
                } while (this.isMatch(x, y));
            }
        }

        this.time.events.loop(1000, this.updateTimer, this);

        this.input.onDown.add(this.selectTile, this);
        this.input.onUp.add(this.deselectTile, this);
    },
    tileAt: function (x, y) {
        if (x < 0 || x >= 6 || y < 0 || y >= 7) {
            return -1;
        }

        return this.gameArray[x][y];
    },
    isMatch: function (x, y) {
        return this.isHorizontalMatch(x, y) || this.isVerticalMatch(x, y);
    },
    isHorizontalMatch: function (x, y) {
        if (this.tileAt(x, y) === null) {
            return true;
        }

        return this.tileAt(x, y).color == this.tileAt(x - 1, y).color && this.tileAt(x, y).color == this.tileAt(x - 2, y).color;
    },
    isVerticalMatch: function (x, y) {
        if (this.tileAt(x, y) === null) {
            return true;
        }

        return this.tileAt(x, y).color == this.tileAt(x, y - 1).color && this.tileAt(x, y).color == this.tileAt(x, y - 2).color;
    },
    selectTile: function (e) {
        if (!this.canPick || this.gamePaused || this.gameOver) {
            return;
        }

        var col = Math.floor((e.x - 24) / 72);
        var row = Math.floor((e.y - 110) / 72);

        var pickedTile = this.tileAt(col, row);

        if (pickedTile === -1) {
            return;
        }

        this.hideHint();

        if (this.selectedTile === null) {
            pickedTile.sprite.scale.setTo(1.2);
            pickedTile.sprite.bringToTop();
            this.selectedTile = pickedTile;
            ENGINE.audioManager.play('select');
            this.input.addMoveCallback(this.moveTile, this);
        } else {
            if (this.areTheSame(pickedTile, this.selectedTile)) {
                this.selectedTile.sprite.scale.setTo(1);
                this.selectedTile = null;
                ENGINE.audioManager.play('select');
            } else {
                if (this.areNext(pickedTile, this.selectedTile)) {
                    this.selectedTile.sprite.scale.setTo(1);
                    this.swapTile(this.selectedTile, pickedTile, true);
                } else {
                    this.selectedTile.sprite.scale.setTo(1);
                    pickedTile.sprite.scale.setTo(1.2);
                    this.selectedTile = pickedTile;
                    this.input.addMoveCallback(this.moveTile, this);
                    ENGINE.audioManager.play('select');
                }
            }
        }
    },
    areTheSame: function (tile1, tile2) {
        return tile1.pos.x === tile2.pos.x && tile1.pos.y === tile2.pos.y;
    },
    areNext: function (tile1, tile2) {
        return Math.abs(tile1.pos.x - tile2.pos.x) + Math.abs(tile1.pos.y - tile2.pos.y) === 1;
    },
    deselectTile: function (e) {
        this.input.deleteMoveCallback(this.moveTile, this);
    },
    moveTile: function (event, pX, pY) {
        var distX = pX - this.selectedTile.sprite.x;
        var distY = pY - this.selectedTile.sprite.y;
        var deltaX = 0;
        var deltaY = 0;

        if (Math.abs(distX) > 32) {
            deltaX = (distX > 0) ? 1 : -1;
        } else if (Math.abs(distY) > 32) {
            deltaY = (distY > 0) ? 1 : -1;
        }

        if (deltaX + deltaY === 0) {
            return;
        }

        var pickedTile = this.tileAt(
            this.selectedTile.pos.x + deltaX,
            this.selectedTile.pos.y + deltaY
        );

        if (pickedTile === -1) {
            return;
        }

        this.selectedTile.sprite.scale.setTo(1);
        this.swapTile(this.selectedTile, pickedTile, true);
        this.input.deleteMoveCallback(this.moveTile, this);
    },
    swapTile: function (tile1, tile2, swapBack) {
        this.canPick = false;

        var from = {
            color: tile1.color,
            sprite: tile1.sprite,
            pos: { x: tile1.pos.x, y: tile1.pos.y }
        };

        var to = {
            color: tile2.color,
            sprite: tile2.sprite,
            pos: { x: tile2.pos.x, y: tile2.pos.y }
        };

        this.gameArray[from.pos.x][from.pos.y].color = to.color;
        this.gameArray[from.pos.x][from.pos.y].sprite = to.sprite;

        this.gameArray[to.pos.x][to.pos.y].color = from.color;
        this.gameArray[to.pos.x][to.pos.y].sprite = from.sprite;

        var tween1 = this.add.tween(this.gameArray[from.pos.x][from.pos.y].sprite).to({
            x: from.pos.x * 72 + 60,
            y: from.pos.y * 72 + 146
        }, 200, Phaser.Easing.Linear.None, true);

        var tween2 = this.add.tween(this.gameArray[to.pos.x][to.pos.y].sprite).to({
            x: to.pos.x * 72 + 60,
            y: to.pos.y * 72 + 146
        }, 200, Phaser.Easing.Linear.None, true);

        ENGINE.audioManager.play('swap');

        tween2.onComplete.add(function () {
            if (!this.matchInBoard() && swapBack) {
                this.swapTile(tile1, tile2, false);
            } else {
                if (this.matchInBoard()) {
                    this.handleMatches();
                } else {
                    this.canPick = true;
                    this.selectedTile = null;
                }
            }
        }, this);
    },
    matchInBoard: function () {
        for (var x = 0; x < 6; x++) {
            for (var y = 0; y < 7; y++) {
                if (this.isMatch(x, y)) {
                    return true;
                }
            }
        }

        return false;
    },
    handleMatches: function () {
        ENGINE.audioManager.play('pop');

        var matches = [];
        for (var x = 0; x < 6; x++) {
            matches[x] = [];
            for (var y = 0; y < 7; y++) {
                matches[x][y] = 0;
            }
        }

        for (var y = 0; y < 7; y++) {
            var colorStreak = 1;
            var currentColor = -1;
            var startStreak = 0;

            for (var x = 0; x < 6; x++) {
                if (this.tileAt(x, y).color === currentColor) {
                    colorStreak += 1;
                }

                if (this.tileAt(x, y).color !== currentColor || x == 6 - 1) {
                    if (colorStreak >= 3) {
                        for (var k = 0; k < colorStreak; k++) {
                            matches[startStreak + k][y] += 1;
                        }
                    }

                    startStreak = x;
                    colorStreak = 1;
                    currentColor = this.tileAt(x, y).color;
                }
            }
        }

        for (var x = 0; x < 6; x++) {
            var colorStreak = 1;
            var currentColor = -1;
            var startStreak = 0;

            for (var y = 0; y < 7; y++) {
                if (this.tileAt(x, y).color === currentColor) {
                    colorStreak += 1;
                }

                if (this.tileAt(x, y).color !== currentColor || y == 7 - 1) {
                    if (colorStreak >= 3) {
                        for (var k = 0; k < colorStreak; k++) {
                            matches[x][startStreak + k] += 1;
                        }
                    }

                    startStreak = y;
                    colorStreak = 1;
                    currentColor = this.tileAt(x, y).color;
                }
            }
        }

        var destroyed = 0;

        for (var x = 0; x < 6; x++) {
            for (var y = 0; y < 7; y++) {
                if (matches[x][y] > 0) {
                    destroyed += 1;

                    var destroyTween = this.add.tween(this.gameArray[x][y].sprite).to({
                        alpha: 0
                    }, 200, Phaser.Easing.Linear.None, true);

                    destroyTween.onComplete.add(function (tile) {
                        tile.destroy();

                        destroyed -= 1;

                        if (destroyed === 0) {
                            this.fallTiles();
                            this.replenishField();
                        }
                    }, this);

                    this.particleArray[x][y].explode(500, 4);

                    this.gameArray[x][y] = null;

                    this.updateScore(50);
                }
            }
        }
    },
    fallTiles: function () {
        for (var y = 7 - 2; y >= 0; y--) {
            for (var x = 0; x < 6; x++) {
                if (this.gameArray[x][y] === null) {
                    continue;
                }

                var holes = this.holesBelow(x, y);


                if (holes === 0) {
                    continue;
                }

                var fallTween = this.add.tween(this.gameArray[x][y].sprite).to({
                    y: this.gameArray[x][y].sprite.y + holes * 72
                }, 100 * holes, Phaser.Easing.Linear.None, true);

                this.gameArray[x][y + holes] = {
                    color: this.gameArray[x][y].color,
                    sprite: this.gameArray[x][y].sprite,
                    pos: { x: x, y: y + holes }
                };

                this.gameArray[x][y] = null;
            }
        }
    },
    holesBelow: function (x, y) {
        var result = 0;

        for (var j = y + 1; j < 7; j++) {
            if (this.gameArray[x][j] === null) {
                result += 1;
            }
        }

        return result;
    },
    replenishField: function () {
        var replenished = 0;

        for (var x = 0; x < 6; x++) {
            var holes = this.holesInRow(x);

            if (holes === 0) {
                continue;
            }

            for (var y = 0; y < holes; y++) {
                this.gameArray[x][y] = {};

                this.gameArray[x][y].pos = { x: x, y: y };

                this.gameArray[x][y].sprite = this.add.sprite(60 + x * 72, 146 + y * 72, 'atlas');
                this.gameArray[x][y].sprite.anchor.setTo(0.5);
                this.gameArray[x][y].sprite.alpha = 1;
                this.tilesGroup.add(this.gameArray[x][y].sprite);

                do {
                    var color = this.rnd.integerInRange(0, 3);
                    this.gameArray[x][y].color = color;
                    this.gameArray[x][y].sprite.frameName = 'tile/' + this.tilesArray[color];
                } while (this.isMatch(x, y))

                replenished += 1;

                var replenishTween = this.add.tween(this.gameArray[x][y].sprite).from({
                    alpha: 0,
                    y: 146 - 72 * (holes - y)
                }, 300, Phaser.Easing.Linear.None, true);

                replenishTween.onComplete.add(function () {
                    replenished -= 1;

                    if (replenished !== 0) {
                        return;
                    }

                    if (this.matchInBoard()) {
                        this.time.events.add(200, this.handleMatches, this);
                    } else {
                        this.hideHint();
                        this.canPick = true;
                        this.selectedTile = null;
                    }

                }, this);
            }
        }
    },
    holesInRow: function (x) {
        var result = 0;

        for (var y = 0; y < 7; y++) {
            if (this.gameArray[x][y] === null) {
                result += 1;
            }
        }

        return result;
    },
    updateTimer: function () {
        if (this.gameOver || this.gamePaused) {
            return;
        }

        if (this.hintTimer >= 5 && this.hintTween === null && this.canPick) {
            this.hintTimer = 0;
            this.showHint();
        } else {
            this.hintTimer += 1;
        }

        if (this.currentTime > 0) {
            this.currentTime -= 1;
            this.add.tween(this.timeBar).to({ width: this.game.width * this.currentTime / this.roundTime }, 1000, Phaser.Easing.Linear.None, true);
        } else {
            this.endGame();

        }
    },
    findHints: function () {
        this.hintArray = [];

        var checkList = [
            [{ x: -2, y: -1 }, { x: -1, y: -1 }, { x: 0, y: -1 }],
            [{ x: 0, y: -2 }, { x: 0, y: -3 }, { x: 0, y: -1 }],
            [{ x: 1, y: -1 }, { x: 2, y: -1 }, { x: 0, y: -1 }],

            [{ x: 1, y: -1 }, { x: 1, y: -2 }, { x: 1, y: 0 }],
            [{ x: 2, y: 0 }, { x: 3, y: 0 }, { x: 1, y: 0 }],
            [{ x: 1, y: 1 }, { x: 1, y: 2 }, { x: 1, y: 0 }],

            [{ x: 1, y: 1 }, { x: 2, y: 1 }, { x: 0, y: 1 }],
            [{ x: 0, y: 2 }, { x: 0, y: 3 }, { x: 0, y: 1 }],
            [{ x: -1, y: 1 }, { x: -2, y: 1 }, { x: 0, y: 1 }],

            [{ x: -1, y: -1 }, { x: -1, y: -2 }, { x: -1, y: 0 }],
            [{ x: -3, y: 0 }, { x: -2, y: 0 }, { x: -1, y: 0 }],
            [{ x: -1, y: 1 }, { x: -1, y: 2 }, { x: -1, y: 0 }]
        ];

        for (var x = 0; x < 6; x++) {
            for (var y = 0; y < 7; y++) {
                for (var i = 0; i < 12; i++) {
                    if (this.tileAt(x, y).color === this.tileAt(x + checkList[i][0].x, y + checkList[i][0].y).color && this.tileAt(x, y).color === this.tileAt(x + checkList[i][1].x, y + checkList[i][1].y).color) {

                        this.hintArray.push([{ x: x, y: y }, { x: x + checkList[i][2].x, y: y + checkList[i][2].y }]);
                    }
                }
            }
        }

        if (this.hintArray.length === 0) {
            this.endGame();

        }
    },
    showHint: function () {
        this.findHints();

        this.currentHint = this.hintArray[this.rnd.integerInRange(0, this.hintArray.length - 1)];

        this.hintTween = {};

        this.hintTween.one = this.add.tween(this.gameArray[this.currentHint[0].x][this.currentHint[0].y].sprite.scale).to({
            x: 1.2,
            y: 1.2
        }, 500, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.hintTween.two = this.add.tween(this.gameArray[this.currentHint[1].x][this.currentHint[1].y].sprite.scale).to({
            x: 1.2,
            y: 1.2
        }, 500, Phaser.Easing.Linear.None, true, 0, -1, true);
    },
    hideHint: function () {
        this.hintTimer = 0;

        if (this.hintTween === null) {
            return;
        }

        this.hintTween.one.stop();
        this.gameArray[this.currentHint[0].x][this.currentHint[0].y].sprite.scale.setTo(1);

        this.hintTween.two.stop();
        this.gameArray[this.currentHint[1].x][this.currentHint[1].y].sprite.scale.setTo(1);

        this.currentHint = null;
        this.hintTween = null;
    },
    updateScore: function (value) {
        var tweened = { score: this.currentScore };
        var tween = this.add.tween(tweened).to({ score: this.currentScore + value }, 250, Phaser.Easing.Linear.None, true);

        tween.onUpdateCallback(function () {
            this.scoreText.setText(Math.floor(tweened.score));
        }, this);

        tween.onComplete.addOnce(function () {
            this.scoreText.setText(this.currentScore /*+ value*/);
        }, this);

        this.currentScore += value;
        console.log(this.currentScore);

    },
    endGame: function () {
        if (this.gameOver) {
            return;
        }

        this.gameOver = true;
        /*console.log('currentScore')
        console.log(this.currentScore)
        console.log(this.highScore);
        console.log('idUserendGame')
        console.log(idUser)
        console.log(idGame)*/

        this.time.events.add(2000, function () {
            ENGINE.audioManager.play('fade');
            this.game.camera.fade(0x249e9d, 500);
        }, this);

        this.time.events.add(2800, function () {
            this.state.start('OverState', true, false, this.currentScore);
        }, this);
    }
};


ENGINE.state.over = function () { };
ENGINE.state.over.prototype = {
    init: function (score) {
        this.score = score;
        this.highScore = ENGINE.localStorage.get();
        this.highScore = highScoreDB;

        if (this.score > this.highScore) {
            ENGINE.localStorage.set(this.score);
        }
    },
    create: function () {
        ENGINE.adManager.addListener();

        this.background = this.add.sprite(0, 0, 'atlas', 'background');

        this.emitter = this.add.emitter(this.game.width * 0.5, this.game.height * 0.5 + 320, 16);
        this.emitter.makeParticles('atlas', 'particleBig');
        this.emitter.setScale(0, 1, 0, 1, 14000, Phaser.Easing.Linear.None)
        this.emitter.setAlpha(0, 0.15, 8000, Phaser.Easing.Linear.None, true);
        this.emitter.minParticleSpeed.setTo(-20, -20);
        this.emitter.maxParticleSpeed.setTo(20, 0);
        this.emitter.setRotation(-20, 20);
        this.emitter.gravity = -20;
        this.emitter.width = 400;
        this.emitter.flow(8000, 500, 1, -1, true);

        this.lights = this.add.sprite(this.game.width * 0.5, -50, 'atlas', 'lights');
        this.lights.anchor.setTo(0.5, 0);
        this.lights.angle = -5;

        this.scoreText = this.add.text(this.game.width * 0.5 + 53, this.game.height * 0.5 - 220, '0', { font: '72pt Pacifico', fill: '#ffffff' });
        this.scoreText.setShadow(4, 4, 'rgba(23, 108, 121, 1)', 0);
        this.scoreText.anchor.setTo(0.5);

        this.scoreIcon = this.add.sprite(this.game.width * 0.5 - this.scoreText.width * 0.5 + 33, this.game.height * 0.5 - 215, 'atlas', 'scoreBig');
        this.scoreIcon.anchor.setTo(1, 0.5);

        this.highScoreText = this.add.text(this.game.width * 0.5 + 40, this.game.height * 0.5 - 100, this.highScore, { font: '72pt Pacifico', fill: '#ffffff' });
        this.highScoreText.setShadow(4, 4, 'rgba(23, 108, 121, 1)', 0);
        this.highScoreText.anchor.setTo(0.5);

        this.highScoreIcon = this.add.sprite(this.game.width * 0.5 - this.highScoreText.width * 0.5 + 20, this.game.height * 0.5 - 90, 'atlas', 'highscoreBig');
        this.highScoreIcon.anchor.setTo(1, 0.5);

        this.restartBtn = this.add.button(this.game.width * 0.5, this.game.height * 0.5 + 110, 'atlas', this.restartGame, this, 'restartBtn/0', 'restartBtn/0', 'restartBtn/1', 'restartBtn/0');
        this.restartBtn.anchor.setTo(0.5)

        this.animateIn();
    },
    animateIn: function () {
        this.add.tween(this.background).from({ alpha: 0 }, 2000, Phaser.Easing.Linear.None, true);

        this.add.tween(this.lights).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 1000);
        this.add.tween(this.lights).to({ angle: 5 }, 4000, Phaser.Easing.Linear.None, true, 0, -1, true);
        this.add.tween(this.lights).to({ y: -200 }, 3000, Phaser.Easing.Linear.None, true, 0, -1, true);

        this.add.tween(this.scoreText).from({ y: 0 }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.scoreText).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);

        this.add.tween(this.scoreIcon).from({ y: 0 }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.scoreIcon).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);

        this.add.tween(this.highScoreText).from({ y: 0 }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.highScoreText).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);

        this.add.tween(this.highScoreIcon).from({ y: 0 }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.highScoreIcon).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);

        this.add.tween(this.restartBtn).from({ y: this.game.height }, 1000, Phaser.Easing.Elastic.Out, true, 500);
        this.add.tween(this.restartBtn).from({ alpha: 0 }, 1000, Phaser.Easing.Linear.None, true, 500);
        this.add.tween(this.restartBtn.scale).to({ x: 1.1, y: 1.1 }, 1000, Phaser.Easing.Linear.None, true, 0, -1, true);

        if (this.score > 0) {
            this.calculateScore();
        }
    },
    restartGame: function () {
        ENGINE.audioManager.play('click');

        this.restartBtn.input.enabled = false;

        ENGINE.audioManager.play('fade');
        this.game.camera.fade(0x249e9d, 500);
        console.log('reload');
        location.reload(true);
        this.time.events.add(700, function () {
            this.state.start('GameState');
        }, this);
    },
    calculateScore: function () {
        this.tweenedScore = 0;

        var tween = this.add.tween(this).to({ tweenedScore: this.score }, 1000, Phaser.Easing.Linear.None, true, 1500);

        tween.onStart.addOnce(function () {
            ENGINE.audioManager.play('counting');
        }, this);

        tween.onUpdateCallback(function () {
            this.scoreText.setText(Math.floor(this.tweenedScore));
            this.scoreIcon.x = this.game.width * 0.5 - this.scoreText.width * 0.5 + 33;
        }, this);

        tween.onComplete.addOnce(function () {
            this.scoreText.setText(this.score);
            this.scoreIcon.x = this.game.width * 0.5 - this.scoreText.width * 0.5 + 33;

            this.calculateHighScore();
        }, this);
    },
    calculateHighScore: function () {
        /*console.log('calculateHighScore');
        console.log(this.score);
        console.log(this.highScore);
        console.log(idUser)
        console.log(idGame)*/

        var xhr = new XMLHttpRequest();
        var data = { "idUser": idUser, "idGame": idGame, "score": this.score, "highScore": this.highScore };

        xhr.open('POST', 'dbRecordGame1.php', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("R=" + JSON.stringify(data));


        if (this.score > this.highScore) {
            this.add.tween(this.highScoreText.scale).to({ x: 1.2, y: 1.2 }, 250, Phaser.Easing.Exponential.Out, true, 600).yoyo(true);
            this.add.tween(this.highScoreIcon.scale).to({ x: 1.2, y: 1.2 }, 250, Phaser.Easing.Exponential.Out, true, 600).yoyo(true);

            this.time.events.add(600, function () {
                ENGINE.audioManager.play('highscore');
            }, this);

            this.tweenedScore = this.highScore;

            var tween = this.add.tween(this).to({ tweenedScore: this.score }, 1000, Phaser.Easing.Linear.None, true, 1200);

            tween.onStart.addOnce(function () {
                ENGINE.audioManager.play('counting');
            }, this);

            tween.onUpdateCallback(function () {
                this.highScoreText.setText(Math.floor(this.tweenedScore));
                this.highScoreIcon.x = this.game.width * 0.5 - this.scoreText.width * 0.5 + 20;
            }, this);

            tween.onComplete.addOnce(function () {
                this.highScoreText.setText(this.score);
                this.highScoreIcon.x = this.game.width * 0.5 - this.scoreText.width * 0.5 + 20;
            }, this);
        }
    },
};