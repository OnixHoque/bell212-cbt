function loadstl(filename, txtbox) {
	document.getElementById(txtbox).style.display = "block";
    STLViewer(filename, "model", function()
			{
				document.getElementById(txtbox).style.display = "none";
			}
    	)
	}

function STLViewer(model, elementID, callback) {
    var elem = document.getElementById(elementID);
    //elem.innerHTML = ""; 
    var camera = new THREE.PerspectiveCamera(70, 
    elem.clientWidth/elem.clientHeight, 1, 100000);
    var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
	renderer.setSize(elem.clientWidth, elem.clientHeight);
	elem.appendChild(renderer.domElement);
	
	window.addEventListener('resize', function () {
    renderer.setSize(elem.clientWidth, elem.clientHeight);
    camera.aspect = elem.clientWidth/elem.clientHeight;
    camera.updateProjectionMatrix();
	}, false);

	var controls = new THREE.OrbitControls(camera, renderer.domElement);
	controls.enableDamping = true;
	controls.rotateSpeed = 0.75;
	controls.dampingFactor = 0.1;
	controls.enableZoom = true;
	controls.autoRotate = true;
	controls.autoRotateSpeed = 1.25;

	var scene = new THREE.Scene();
	//var light2 = new THREE.HemisphereLight(0xFFFFFF, 10.5);
	//light2.position = new THREE.Vector3(0, -100, 0);
	scene.add(new THREE.HemisphereLight(0xFFFFFF, .5));
	//scene.add(light2);

	(new THREE.STLLoader()).load(model, function (geometry) {
    var material = new THREE.MeshPhongMaterial({ 
        color: 0xa0a3a7, 
        specular: 0, 
        shininess: 100});



    var mesh = new THREE.Mesh(geometry, material);
    
    scene.add(mesh);

    

    var middle = new THREE.Vector3();
	geometry.computeBoundingBox();
	geometry.boundingBox.getCenter(middle);
	mesh.position.x = -1 * middle.x;
	mesh.position.y = -1* middle.y;
	mesh.position.z = -1* middle.z;

	var largestDimension = Math.max(geometry.boundingBox.max.x,
                            geometry.boundingBox.max.y, 
                            geometry.boundingBox.max.z)
	// mesh.position.x = -1 * largestDimension;
	// mesh.position.y = -1* largestDimension;
	// mesh.position.z = -1* largestDimension;
	camera.position.z = largestDimension * .75;

	var animate = function () {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
	};
	animate();
	callback();
    });
    //
}