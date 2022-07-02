Type vector
    x As Single
    y As Single
    z As Single
    w As Single
End Type

Dim Shared vector As vector

'Set the position you want to rotate
vector.x = 1
vector.y = 2
vector.z = -1
vector.w = 0

'Call the rotation function, the given parameters will rotate it 90 degrees around the y axis
Call rotateVector(0, 3.1459265 / 2, 0)

Print vector.x, vector.y, vector.z, vector.w
' Prints 1 2 1 0

Sub rotateVector (rx As Single, ry As Single, rz As Single)
    Dim nvector As vector
    nvector.x = (vector.x * Cos(rz) * Cos(ry)) + (vector.y * Sin(rz) * Cos(ry)) - vector.z * Sin(ry)
    nvector.y = (vector.x * (Cos(rz) * Sin(ry) * Sin(rx) - Sin(rz) * Cos(rx))) + (vector.y * (Sin(rz) * Sin(ry) * Sin(rx) + Cos(rz) * Cos(rx))) + (vector.z * Cos(ry) * Sin(rx))
    nvector.z = (vector.x * (Cos(rz) * Sin(ry) * Cos(rx) + Sin(rz) * Sin(rx))) + (vector.y * (Sin(rz) * Sin(ry) * Cos(rx) - Cos(rz) * Sin(rx))) + (vector.z * Cos(ry) * Cos(rx))

    vector.x = nvector.x: vector.y = nvector.y: vector.z = nvector.z: vector.w = 1
End Sub
